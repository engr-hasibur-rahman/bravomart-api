<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Interfaces\TagInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagManageController extends Controller
{
    public function __construct(protected TagInterface $tagRepo){}
    public function index(Request $request)
    {
        return $this->tagRepo->getPaginatedTag(
            $request->limit ?? 10,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
        );
    }
    public function store(TagRequest $request): JsonResponse
    {
        $author = $this->tagRepo->store($request->all());
        if ($author) {
            return $this->success(translate('messages.save_success', ['name' => 'Tag']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Tag']));
        }
    }
    public function show(Request $request){
        return $this->tagRepo->getTagById($request->id);
    }
    public function update(TagRequest $request){
        $author = $this->tagRepo->update($request->all());
        if ($author) {
            return $this->success(translate('messages.update_success', ['name' => 'Tag']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Tag']));
        }
    }
    public function destroy($id){
        $this->tagRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }
    
}
