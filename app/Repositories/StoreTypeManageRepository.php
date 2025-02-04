<?php

namespace App\Repositories;

use App\Interfaces\StoreTypeManageInterface;
use App\Models\StoreType;
use App\Models\Translation;
use Illuminate\Http\Request;

class StoreTypeManageRepository implements StoreTypeManageInterface
{
    public function __construct(protected StoreType $storeType, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->storeType->translationKeys;
    }

    public function getAllStoreTypes(array $filters)
    {
        $query = StoreType::with('related_translations');
        if (isset($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm)
                    ->orWhereHas('related_translations', function ($q) use ($searchTerm) {
                        $q->whereIn('key', ['name', 'description'])
                            ->where('value', 'LIKE', $searchTerm);
                    });
            });
        }
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        $perPage = $filters['per_page'] ?? 10;
        $store_types = $query->paginate($perPage);
        if (!empty($store_types)) {
            return $store_types;
        } else {
            return null;
        }
    }

    public function updateStoreType(array $data)
    {
        if (empty($data)) {
            return false;
        }
        $storeType = StoreType::find($data['id']);
        if (!$storeType) {
            return null;
        }
        $storeType->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'] ?? $storeType->status,
            'image' => $data['image'] ?? $storeType->image,
        ]);
        return $storeType->id;
    }

    public function getStoreTypeById(int $id)
    {
        $storeType = StoreType::with('related_translations')->find($id);
        if (!$storeType) {
            return null;
        }
        return $storeType;
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

    public function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        if (empty($request['translations'])) {
            return false;  // Return false if no translations are provided
        }

        $translations = [];
        foreach ($request['translations'] as $translation) {
            foreach ($colNames as $key) {
                // Fallback value if translation key does not exist
                $translatedValue = $translation[$key] ?? null;

                // Skip translation if the value is NULL
                if ($translatedValue === null) {
                    continue; // Skip this field if it's NULL
                }

                // Check if a translation exists for the given reference path, ID, language, and key
                $trans = $this->translation
                    ->where('translatable_type', $refPath)
                    ->where('translatable_id', $refid)
                    ->where('language', $translation['language_code'])
                    ->where('key', $key)
                    ->first();

                if ($trans) {
                    // Update the existing translation
                    $trans->value = $translatedValue;
                    $trans->save();
                } else {
                    // Prepare new translation entry for insertion
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

        // Insert new translations if any
        if (!empty($translations)) {
            $this->translation->insert($translations);
        }

        return true;
    }

}
