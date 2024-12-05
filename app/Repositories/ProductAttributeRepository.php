<?php

namespace App\Repositories;

use App\Interfaces\ProductAttributeInterface;
use App\Models\ProductAttribute;
use App\Models\Translation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 *
 * @package namespace App\Repositories;
 */
class ProductAttributeRepository implements ProductAttributeInterface
{
    public function __construct(protected ProductAttribute $attribute, protected Translation $translation) {}
    public function translationKeys(): mixed
    {
        return $this->attribute->translationKeys;
    }
    public function model()
    {
        return ProductAttribute::class;
    }
    public function store(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $attribute = ProductAttribute::create($data);
            return $attribute->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getPaginatedAttribute(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $tag = ProductAttribute::leftJoin('translations', function ($join) use ($language) {
            $join->on('tags.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', ProductAttribute::class)
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

}
