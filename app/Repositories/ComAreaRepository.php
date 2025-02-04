<?php

namespace App\Repositories;

use App\Helpers\ComHelper;
use App\Http\Resources\Translation\AreaTranslationResource;
use App\Http\Resources\Translation\TranslationResource;
use App\Models\StoreArea;
use App\Interfaces\ComAreaInterface;
use Illuminate\Support\Facades\DB;


/**
 *
 * @package namespace App\Repositories;
 */
class ComAreaRepository implements ComAreaInterface
{

    public function __construct(protected StoreArea $area) {}

    public function model(): string
    {
        return StoreArea::class;
    }

    public function translationKeys(): mixed
    {
        return  $this->area->translationKeys;
    }

    public function index(): mixed
    {
        return null;
    }

    public function getPaginatedList(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $areas = StoreArea::leftJoin('translations', function ($join) use ($language) {
            $join->on('store_areas.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', StoreArea::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'name');
        })
            ->select(
                'store_areas.*',
                DB::raw('COALESCE(translations.value, store_areas.name) as name'),
                DB::raw('(SELECT COUNT(*) FROM stores WHERE stores.area_id = store_areas.id) AS store_count') // Store count
            );

        // Apply search filter
        if ($search) {
            $areas->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', store_areas.name, translations.value)"), 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        return $areas
            ->orderBy($sortField ?? 'id', $sort ?? 'asc')
            ->paginate($limit);
    }


    public function getById($id): mixed
    {
        // Find the area by id
        $area = $this->area->with('related_translations')->findOrFail($id);
//        // Fetch translation which is initialized in StoreArea Model grouped by language
//        $translations = $area->translations()->get()->groupBy('language');
//
//        // Initialize an array to hold the transformed data
//        $transformedData = [];
//
//        foreach ($translations as $language => $items) {
//            $languageInfo = ['language' => $language];
//            /* iterate all Column to Assign Language Value */
//            foreach ($this->area->translationKeys as $columnName) {
//                $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
//            }
//            $transformedData[] = $languageInfo;
//        }
        $formated_coordinates = json_decode($area->coordinates[0]->toJson(), true);


        return [
            'id' => $area->id,
            'code' => $area->code,
            'state' => $area->state,
            'city' => $area->city,
            'status' => $area->status,
            'center_latitude' => $area->center_latitude,
            'center_longitude' => $area->center_longitude,
            'created_by' => $area->created_by,
            'coordinates' => ComHelper::format_coordiantes($formated_coordinates['coordinates']),
            'translations' => AreaTranslationResource::collection($area->related_translations->groupBy('language')),
        ];
    }
    public function store(array $data): string|object
    {

        $area = $this->area->newInstance();

        foreach ($data as $column => $value) {        
            // skips the translation field
            if ($column <> 'translations') {
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
            // skips the translation field
            if ($column <> 'translations') {
                $area[$column] = $value;
            }
        }
        $area->save();
        return $area;
    }
    public function changeStatus(int|string $id, string $status = ""): mixed
    {
        $area = $this->area->findOrFail($id);
        $area->status = !$area->status;
        $area->save();
        return $area;
    }

    public function delete($id): true
    {
        $area = $this->area->findOrFail($id);
        $area->translations()->delete();
        $area->delete();
        return true;
    }
}
