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

    public function getPaginatedBanner(int|string $per_page, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        // Define the base query for the Banner model
        $banner = Banner::query()->with(['related_translations' => function ($query) use ($language) {
            $query->where('language', $language)
                ->whereIn('key', ['title', 'description', 'button_text']);
        }]);

        // Apply search filter if search parameter exists
        if ($search) {
            $banner->where(function ($query) use ($search, $language) {
                $query->whereHas('related_translations', function ($subQuery) use ($search, $language) {
                    $subQuery->where('language', $language)
                        ->where('value', 'like', "%{$search}%");
                })
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        if ($sortField && $sort) {
            $banner->orderBy($sortField, $sort);
        }
        if (auth('api')->user()->store_owner == 1) {
            return $banner
                ->where('store_id',auth('api')->user()->stores)
                ->where('location', 'store_page')
                ->paginate($per_page);
        } else {
            return $banner->paginate($per_page);
        }
        // Apply pagination and return the result

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
                'location' => auth('api')->user()->store_owner == 1 ? 'store_page' : $data['location'],
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
            $banner = Banner::with('related_translations', 'creator', 'store')->findorfail($id);
            if ($banner) {
                return $banner;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data)
    {
        try {
            $banner = Banner::findOrFail($data['id']);
            $data = Arr::except($data, ['translations']);

            $banner->update([
                'user_id' => auth('api')->id(),
                'store_id' => $data['store_id'] ?? null,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'background_image' => $data['background_image'] ?? null,
                'thumbnail_image' => $data['thumbnail_image'] ?? null,
                'button_text' => $data['button_text'] ?? null,
                'button_color' => $data['button_color'] ?? null,
                'redirect_url' => $data['redirect_url'] ?? null,
                'location' => auth('api')->user()->store_owner == 1 ? 'store_page' : $data['location'],
                'type' => $data['type'] ?? null,
                'status' => $data['status'] ?? $banner->status,
            ]);

            return $banner->id;
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

