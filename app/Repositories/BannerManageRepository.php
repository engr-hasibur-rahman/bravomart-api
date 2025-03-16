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

    public function getPaginatedBanner(
        int|string $per_page,
        int        $page,
        string     $language,
        string     $search,
        string     $sortField,
        string     $sort,
        array      $filters
    )
    {
        $query = Banner::query();
//            ->with([
//                'related_translations' => function ($q) use ($language) {
//                    $q->where('language', $language)
//                        ->whereIn('key', ['title', 'description', 'button_text']);
//                }
//            ]);

        // Apply search filter if search parameter exists
        if (!empty($search)) {
            $query->where(function ($q) use ($search, $language) {
                $q->whereHas('related_translations', function ($subQuery) use ($search, $language) {
                    $subQuery->where('language', $language)
                        ->where('value', 'like', "%{$search}%");
                })
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        if (!empty($sortField) && !empty($sort)) {
            $query->orderBy($sortField, $sort);
        }

        // Paginate the results
        return $query->with('related_translations')->paginate($per_page ?? 10);
    }


    public function store(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $existing_banner = Banner::where('type', $data['type'])->get();
            if (count($existing_banner) > 0) {
                Banner::where('type', $data['type'])->update(['status' => 0]);
            }
            $banner = Banner::create([
                'user_id' => auth('api')->id(),
                'store_id' => $data['store_id'] ?? null,
                'title' => $data['title'],
                'title_color' => $data['title_color'] ?? null,
                'description' => $data['description'] ?? null,
                'description_color' => $data['description_color'] ?? null,
                'background_image' => $data['background_image'] ?? null,
                'background_color' => $data['background_color'] ?? null,
                'thumbnail_image' => $data['thumbnail_image'] ?? null,
                'button_text' => $data['button_text'] ?? null,
                'button_text_color' => $data['button_text_color'] ?? null,
                'button_hover_color' => $data['button_hover_color'] ?? null,
                'button_color' => $data['button_color'] ?? null,
                'redirect_url' => $data['redirect_url'] ?? null,
                'location' => 'home_page',
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
                'title_color' => $data['title_color'] ?? null,
                'description' => $data['description'] ?? null,
                'description_color' => $data['description_color'] ?? null,
                'background_image' => $data['background_image'] ?? null,
                'background_color' => $data['background_color'] ?? null,
                'thumbnail_image' => $data['thumbnail_image'] ?? null,
                'button_text' => $data['button_text'] ?? null,
                'button_text_color' => $data['button_text_color'] ?? null,
                'button_hover_color' => $data['button_hover_color'] ?? null,
                'button_color' => $data['button_color'] ?? null,
                'redirect_url' => $data['redirect_url'] ?? null,
                'location' => 'home_page',
                'type' => $data['type'] ?? null,
            ]);

            return $banner->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function changeStatus(int $id)
    {
        $banner = Banner::find($id);

        if ($banner) {
            // First, deactivate other banners of the same type
            Banner::where('type', $banner->type)
                ->where('status', 1) // Only deactivate active banners
                ->where('id', '!=', $id) // Exclude the current banner
                ->update(['status' => 0]);

            // Now, toggle the status of the selected banner
            $banner->update(['status' => !$banner->status]);

            return true;
        }

        return false;
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

