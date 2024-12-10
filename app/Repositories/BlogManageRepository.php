<?php

namespace App\Repositories;

use App\Interfaces\BlogManageInterface;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Coupon;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class BlogManageRepository implements BlogManageInterface
{
    public function __construct(protected Blog $blog, protected BlogCategory $blogCategory, protected Translation $translation) {}
    public function translationKeys(): mixed
    {
        return $this->blogCategory->translationKeys;
    }
    /* <-------------------------------------------- BLOG CATEGORY MANAGEMENT START ---------------------------------------------------------> */
    public function getPaginatedCategory(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $blogCategory = BlogCategory::leftJoin('translations as name_translations', function ($join) use ($language) {
            $join->on('blog_categories.id', '=', 'name_translations.translatable_id')
                ->where('name_translations.translatable_type', '=', BlogCategory::class)
                ->where('name_translations.language', '=', $language)
                ->where('name_translations.key', '=', 'name');
        })
            ->select(
                'blog_categories.*',
                DB::raw('COALESCE(name_translations.value, blog_categories.name) as name'),
            );
        // Apply search filter if search parameter exists
        if ($search) {
            $blogCategory->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', blog_categories.name, name_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $blogCategory
            ->orderBy($sortField, $sort)
            ->paginate($limit);
    }
    public function getCategoryById(int|string $id)
    {
        try {
            $blogCategory = BlogCategory::find($id);
            $translations = $blogCategory->translations()->get()->groupBy('language');
            // Initialize an array to hold the transformed data
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];
                /* iterate all Column to Assign Language Value */
                foreach ($this->blogCategory->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }
            if ($blogCategory) {
                return response()->json([
                    "status" => true,
                    "status_code" => 201,
                    "massage" => __('messages.data_found'),
                    "data" => $blogCategory->toArray(),
                    'translations' => $transformedData,
                ], 201);
            } else {
                return response()->json([
                    "massage" => __('messages.data_not_found')
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /* <-------------------------------------------- BLOG CATEGORY MANAGEMENT END ---------------------------------------------------------> */
    /* <-------------------------------------------- COMMON MANAGEMENT START ---------------------------------------------------------> */
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
    public function delete(int|string $id , string $modelClass)
    {
        try {
            $final = $modelClass::findOrFail($id);
            $this->deleteTranslation($final->id,$modelClass);
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
    public function storeTranslation(Request $request, int|string $refid, string $refPath, array  $colNames): bool
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
    public function updateTranslation(Request $request, int|string $refid, string $refPath, array  $colNames): bool
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

    /* <-------------------------------------------- COMMON MANAGEMENT END ---------------------------------------------------------> */
}
