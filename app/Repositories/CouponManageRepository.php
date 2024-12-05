<?php

namespace App\Repositories;

use App\Interfaces\CouponManageInterface;
use App\Models\Coupon;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class CouponManageRepository implements CouponManageInterface
{
    public function __construct(protected Coupon $coupon, protected Translation $translation) {}
    public function translationKeys(): mixed
    {
        return $this->coupon->translationKeys;
    }
    public function model(): string
    {
        return Coupon::class;
    }
    public function getPaginatedCoupon(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $coupon = Coupon::leftJoin('translations as name_translations', function ($join) use ($language) {
            $join->on('coupons.id', '=', 'name_translations.translatable_id')
                ->where('name_translations.translatable_type', '=', Coupon::class)
                ->where('name_translations.language', '=', $language)
                ->where('name_translations.key', '=', 'name');
        })
            ->leftJoin('translations as description_translations', function ($join) use ($language) {
                $join->on('coupons.id', '=', 'description_translations.translatable_id')
                    ->where('description_translations.translatable_type', '=', Coupon::class)
                    ->where('description_translations.language', '=', $language)
                    ->where('description_translations.key', '=', 'description');
            })
            ->select(
                'coupons.*',
                DB::raw('COALESCE(name_translations.value, coupons.title) as title'),
                DB::raw('COALESCE(description_translations.value, coupons.description) as description')
            );
        // Apply search filter if search parameter exists
        if ($search) {
            $coupon->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', coupons.title, name_translations.value, coupons.description, description_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $coupon
            ->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
            ->paginate($limit);
    }
    public function store(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $coupon = Coupon::create($data);
            return $coupon->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getCouponById(int|string $id)
    {
        try {
            $coupon = Coupon::find($id);
            $translations = $coupon->translations()->get()->groupBy('language');
            // Initialize an array to hold the transformed data
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];
                /* iterate all Column to Assign Language Value */
                foreach ($this->coupon->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }
            if ($coupon) {
                return response()->json([
                    "data" => $coupon->toArray(),
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
            $coupon = Coupon::findOrFail($data['id']);
            if ($coupon) {
                $data = Arr::except($data, ['translations']);
                $coupon->update($data);
                return $coupon->id;
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
            $coupon = Coupon::findOrFail($id);
            $this->deleteTranslation($coupon->id,Coupon::class);
            $coupon->delete();
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
}
