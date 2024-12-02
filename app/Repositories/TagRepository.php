<?php

namespace App\Repositories;

use App\Interfaces\TagInterface;
use App\Models\Tag;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class TagRepository implements TagInterface
{
    public function __construct(protected Tag $tag, protected Translation $translation) {}
    public function translationKeys(): mixed
    {
        return $this->tag->translationKeys;
    }
    public function model(): string
    {
        return Tag::class;
    }
    public function getPaginatedTag(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $tag = Tag::leftJoin('translations', function ($join) use ($language) {
            $join->on('tags.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', Tag::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'name');
        })
            ->select(
                'tags.*',
                DB::raw('COALESCE(translations.value, tags.name) as name')
            );


        // Apply search filter if search parameter exists
        if ($search) {
            $tag->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', tags.name, translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $tag
            ->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
            ->paginate($limit);
    }
    public function store(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $tag = Tag::create($data);
            return $tag->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getTagById(int|string $id)
    {
        try {
            $tag = Tag::find($id);
            $translations = $tag->translations()->get()->groupBy('language');
            // Initialize an array to hold the transformed data
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];
                /* iterate all Column to Assign Language Value */
                foreach ($this->tag->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }
            if ($tag) {
                return response()->json([
                    "data" => $tag->toArray(),
                    'translations' => $transformedData,
                    "massage" => "Data was found"
                ], 201);
            } else {
                return response()->json([
                    "massage" => "Data was not found"
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update(array $data)
    {
        try {
            $tag = Tag::findOrFail($data['id']);
            if ($tag) {
                $data = Arr::except($data, ['translations']);
                $tag->update($data);
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete(int|string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();
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
}
