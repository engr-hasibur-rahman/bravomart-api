<?php

namespace App\Repositories;

use App\Interfaces\StoreManageInterface;
use App\Models\ComStore;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class StoreManageRepository implements StoreManageInterface
{
    public function __construct(protected ComStore $store, protected Translation $translation)
    {
    }

    public function translationKeys(): mixed
    {
        return $this->store->translationKeys;
    }

    public function model(): string
    {
        return ComStore::class;
    }

    public function getPaginatedStore(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $store = ComStore::leftJoin('translations as name_translations', function ($join) use ($language) {
            $join->on('com_merchant_stores.id', '=', 'name_translations.translatable_id')
                ->where('name_translations.translatable_type', '=', ComStore::class)
                ->where('name_translations.language', '=', $language)
                ->where('name_translations.key', '=', 'name');
        })->select(
                'com_merchant_stores.*',
                DB::raw('COALESCE(name_translations.value, com_merchant_stores.name) as name'),
            );

        // Apply search filter if search parameter exists
        if ($search) {
            $store->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', com_merchant_stores.name, name_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $store
            ->where('merchant_id', auth('api')->id())
            ->orderBy($sortField, $sort)
            ->paginate($limit);
    }

    public function store(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $data['merchant_id'] = auth('api')->id();
            $store = ComStore::create($data);
            return $store->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getStoreById(int|string $id)
    {
        try {
            $store = ComStore::find($id);
            $translations = $store->translations()->get()->groupBy('language');
            // Initialize an array to hold the transformed data
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];
                /* iterate all Column to Assign Language Value */
                foreach ($this->store->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }
            if ($store) {
                return response()->json([
                    "data" => $store->toArray(),
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
            $store = ComStore::findOrFail($data['id']);
            if ($store) {
                $data = Arr::except($data, ['translations']);
                $store->update($data);
                return $store->id;
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
            $store = ComStore::findOrFail($id);
            $this->deleteTranslation($store->id, ComStore::class);
            $store->delete();
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

    // Fetch deleted records(true = only trashed records, false = all records with trashed)
    public function records(bool $onlyDeleted = false)
    {
        try {
            switch ($onlyDeleted) {
                case true:
                    $records = ComStore::onlyTrashed()->get();
                    break;

                default:
                    $records = ComStore::withTrashed()->get();
                    break;
            }
            return $records;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getOwnerStores()
    {
        if (!auth('api')->check()) {
            unauthorized_response();
        }

        $seller_id = auth('api')->id();

        $stores = ComStore::with('related_translations') // Load all related translations
        ->where('merchant_id', $seller_id)
            ->where('enable_saling', 1)
            ->where('status', 1)
            ->get();

        return $stores;
    }
}
