<?php

namespace App\Repositories;

use App\Interfaces\PageManageInterface;
use App\Models\Page;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class PageManageRepository implements PageManageInterface
{
    public function __construct(protected Page $page, protected Translation $translation)
    {
    }

    public function translationKeysForPage(): mixed
    {
        return $this->page->translationKeys;
    }    
 
    public function getPaginatedPage(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $blog = Page::leftJoin('translations as title_translations', function ($join) use ($language) {
            $join->on('blogs.id', '=', 'title_translations.translatable_id')
                ->where('title_translations.translatable_type', '=', Page::class)
                ->where('title_translations.language', '=', $language)
                ->where('title_translations.key', '=', 'title');
        })
            ->leftJoin('translations as content_translations', function ($join) use ($language) {
                $join->on('blogs.id', '=', 'content_translations.translatable_id')
                    ->where('content_translations.translatable_type', '=', Page::class)
                    ->where('content_translations.language', '=', $language)
                    ->where('content_translations.key', '=', 'content');
            })           
            ->select(
                'blogs.*',
                DB::raw('COALESCE(title_translations.value, pages.title) as title'),
                DB::raw('COALESCE(content_translations.value, pages.content) as content'),
                DB::raw('COALESCE(meta_title_translations.value, pages.meta_title) as meta_title'),
                DB::raw('COALESCE(meta_content_translations.value, pages.meta_description) as meta_description'),
                DB::raw('COALESCE(meta_keywords_translations.value, pages.meta_keywords) as meta_keywords')
            );
        // Apply search filter if search parameter exists
        if ($search) {
            $blog->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', blogs.title, blogs.description, blogs.meta_title, blogs.meta_description, blogs.meta_keywords)"), 'like', "%{$search}%")
                    ->orWhere(DB::raw("CONCAT_WS(' ', title_translations.value, content_translations.value, meta_title_translations.value, meta_content_translations.value, meta_keywords_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        $paginatedBlog = $blog
            ->orderBy($sortField, $sort)
            ->paginate($limit);
        return BlogListResource::collection($paginatedBlog);
    }

    public function getPageById(int|string $id)
    {
        try {
            $blog = Blog::find($id);

            if (!$blog) {
                return response()->json([
                    "message" => __('messages.data_not_found')
                ], 404);
            }

            // Get all translations grouped by language
            $translations = $blog->translations()->get()->groupBy('language');

            // Prepare translations data
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];

                // Iterate all column names to assign language values
                foreach ($this->blog->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }

            // Return response with BlogDetailsResource and translations
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => new BlogDetailsResource($blog),
                'translations' => $transformedData
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }  
    public function store(array $data, string $modelClass)
    {
        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("The provided model class does not exist: $modelClass");
        }
        try {
            $data = Arr::except($data, ['translations']);
            $final = $modelClass::create($data);
            return $final->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, string $modelClass)
    {
        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("The provided model class does not exist: $modelClass");
        }
        try {
            $final = $modelClass::findOrFail($data['id']);
            if ($final) {
                $data = Arr::except($data, ['translations']);
                $final->update($data);
                return $final->id;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete(int|string $id, string $modelClass)
    {
        try {
            $final = $modelClass::findOrFail($id);
            $this->deleteTranslation($final->id, $modelClass);
            $final->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function deleteTranslation(int|string $id, string $translatable_type)
    {
        try {
            $translation = Translation::where('translatable_id', $id)
                ->where('translatable_type', $translatable_type)
                ->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        $translations = [];
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }
                    // Collect translation data
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }
        if (count($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }

    public function updateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        $translations = [];
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }

                    $trans = $this->translation->where('translatable_type', $refPath)->where('translatable_id', $refid)
                        ->where('language', $translation['language_code'])->where('key', $key)->first();
                    if ($trans != null) {
                        $trans->value = $translatedValue;
                        $trans->save();
                    } else {
                        $translations[] = [
                            'translatable_type' => $refPath,
                            'translatable_id' => $refid,
                            'language' => $translation['language_code'],
                            'key' => $key,
                            'value' => $translatedValue,
                        ];
                    }
                }
            }
        }
        if (count($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }

}
