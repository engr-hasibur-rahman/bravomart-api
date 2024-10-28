<?php

namespace App\Repositories;

use App\Models\ComArea;
use App\Interfaces\ComAreaInterface;


/**
 *
 * @package namespace App\Repositories;
 */
class ComAreaRepository implements ComAreaInterface
{

    public function __construct(protected ComArea $area) {}

    public function model()
    {
        return ComArea::class;
    }

    public function translationKeys()
    {
        return  $this->area->translationKeys;
    }

    public function index()
    {
        return null;
    }

    public function getById($id)
    {
        $area = $this->area->findOrFail($id);
        $translations = $area->translations()->get()->groupBy('language');

        // Initialize an array to hold the transformed data
        $transformedData = [];

        foreach ($translations as $language => $items) {
            $languageInfo = ['language' => $language];
            /* iterate all Column to Assign Language Value */
            foreach ($this->area->translationKeys as $columnName) {
                $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
            }
            $transformedData[] = $languageInfo;
        }

        return [
            'id' => $area->id,
            'code' => $area->code,
            'name' => $area->name,
            'coordinates' => $area->coordinates,
            'translations' => $transformedData,
        ];
    }


    public function store(array $data): string|object
    {
        $area = $this->area->newInstance();
        foreach ($data as $column => $value) {
            if ($column != 'translations') {
                $area[$column] = $value;
            }
        }
        $area->save();

        return $area;
    }

    public function update(array $data, $id): string|object
    {
        $area = $this->area->findOrFail($id);

        foreach ($data as $column => $value) {
            if ($column <> 'translations') {
                $area[$column] = $value;
            }
        }
        $area->save();

        return $area;
    }


    public function changeStatus(int|string $id, string $status = "")
    {
        $area = $this->area->findOrFail($id);
        $area->status = !$area->status;
        $area->save();
        return $area;
    }

    public function delete($id)
    {
        $area = $this->area->findOrFail($id);
        $area->translations()->delete();
        $area->delete();
        return true;
    }
}
