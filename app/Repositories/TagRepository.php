<?php

namespace App\Repositories;

use App\Interfaces\TagInterface;
use App\Models\Tag;

class TagRepository implements TagInterface
{
    public function getPaginatedTag(int|string $limit, string $search, string $sortField, string $sort)
    {
        $author = Tag::orderBy($request->sortField ?? 'id', $request->sort ?? 'asc');
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
            $author = Tag::create($data);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getTagById(int|string $id){
        try {
            $tag = Tag::find($id);
            if ($tag) {
                return response()->json([
                    "data" => $tag->toArray(),
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
            $tag = Tag::findOrFail($data['id']);
            if ($tag) {
                $tag->update($data);
                return true;
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
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
