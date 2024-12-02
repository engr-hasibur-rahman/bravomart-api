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
    public function store(array $data)
    {
        try {
            $author = ProductAuthor::create($data);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update(array $data)
    {
        try {
            $author = ProductAuthor::findOrFail($data['id']);
            if ($author) {
                $author->update($data);
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getAuthorById(int|string $id)
    {
        try {
            $author = ProductAuthor::find($id);
            if ($author) {
                return response()->json([
                    "data" => $author->toArray(),
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
    public function changeStatus(array $data): mixed
    {
        $author = ProductAuthor::findOrFail($data["id"]);
        $author->status = $data["status"];
        $author->save();
        return $author;
    }
    public function delete(int|string $id)
    {
        try {
            $author = ProductAuthor::findOrFail($id);
            $author->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
