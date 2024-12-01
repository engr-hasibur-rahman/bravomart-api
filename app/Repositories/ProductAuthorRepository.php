<?php

namespace App\Repositories;

use App\Helpers\ComHelper;
use App\Models\ProductAuthor;
use App\Interfaces\ProductAuthorInterface;
use Illuminate\Support\Facades\DB;


/**
 *
 * @package namespace App\Repositories;
 */
class ProductAuthorRepository implements ProductAuthorInterface
{
    public function __construct(protected ProductAuthor $author) {}
    public function model(): string
    {
        return ProductAuthor::class;
    }
    public function index(): mixed
    {
        return null;
    }
    public function getPaginatedAuthor(int|string $limit, string $search, string $sortField, string $sort)
    {
        $author = ProductAuthor::orderBy($request->sortField ?? 'id', $request->sort ?? 'asc');
        if ($search) {
            $author->where(function ($query) use ($search) {
                $query->where("name", 'like', "%{$search}%");
            });
        }
        return $author
            ->paginate($limit);
    }
}
