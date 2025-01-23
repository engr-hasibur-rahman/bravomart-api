<?php

namespace App\Repositories;

use App\Interfaces\BannerManageInterface;
use App\Models\Banner;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BannerManageRepository implements BannerManageInterface
{
    public function __construct(protected Banner $banner, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->banner->translationKeys;
    }

    public function getPaginatedBanner(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $banner = Banner::leftJoin('translations as title_translations', function ($join) use ($language) {
            $join->on('banners.id', '=', 'title_translations.translatable_id')
                ->where('title_translations.translatable_type', '=', Banner::class)
                ->where('title_translations.language', '=', $language)
                ->where('title_translations.key', '=', 'title');
        })
            ->leftJoin('translations as description_translations', function ($join) use ($language) {
                $join->on('banners.id', '=', 'description_translations.translatable_id')
                    ->where('description_translations.translatable_type', '=', Banner::class)
                    ->where('description_translations.language', '=', $language)
                    ->where('description_translations.key', '=', 'description');
            })
            ->select(
                'banners.*',
                DB::raw('COALESCE(title_translations.value, banners.title) as title'),
                DB::raw('COALESCE(description_translations.value, banners.description) as description')
            );
        // Apply search filter if search parameter exists
        if ($search) {
            $banner->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', banners.title, name_translations.value, banners.description, description_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $banner
            ->orderBy($sortField, $sort)
            ->paginate($limit);
    }

    public function store(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $banner = Banner::create([
                'user_id' => auth('api')->id(),
                'store_id' => $data['store_id'] ?? null,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'background_image' => $data['background_image'] ?? null,
                'thumbnail_image' => $data['thumbnail_image'] ?? null,
                'button_text' => $data['button_text'] ?? null,
                'button_color' => $data['button_color'] ?? null,
                'redirect_url' => $data['redirect_url'] ?? null,
                'location' => auth('api')->activity_scope == 'system_level' ? 'home_page' : 'store_page',
                'type' => $data['type'] ?? null,
                'status' => 1,
            ]);
            return $banner->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getBannerById(int|string $id)
    {
        try {
            $banner = Banner::find($id);
            $translations = $banner->translations()->get()->groupBy('language');
            // Initialize an array to hold the transformed data
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];
                /* iterate all Column to Assign Language Value */
                foreach ($this->banner->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }
            if ($banner) {
                return response()->json([
                    "data" => $banner->toArray(),
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
            $banner = Banner::findOrFail($data['id']);
            if ($banner) {
                $data = Arr::except($data, ['translations']);
                $banner->update($data);
                return $banner->id;
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
            $banner = Banner::findOrFail($id);
            $this->deleteTranslation($banner->id, Banner::class);
            $banner->delete();
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

