<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Interfaces\TagInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagManageController extends Controller
{
    public function __construct(protected TagInterface $tagRepo) {}
    public function index(Request $request)
    {
        return $this->tagRepo->getPaginatedTag(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
    }
    public function store(TagRequest $request): JsonResponse
    {
        $created_by = Auth::user()->id;
        $request['created_by'] = $created_by;
        $tag = $this->tagRepo->store($request->all());
        createOrUpdateTranslation($request, $tag, 'App\Models\Tag', $this->tagRepo->translationKeys());
        if ($tag) {
            return $this->success(translate('messages.save_success', ['name' => 'Tag']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Tag']));
        }
    }
    public function show(Request $request)
    {
        return $this->tagRepo->getTagById($request->id);
    }
    public function update(TagRequest $request)
    {
        $tag = $this->tagRepo->update($request->all());
        createOrUpdateTranslation($request, $tag, 'App\Models\Tag', $this->tagRepo->translationKeys());
        if ($tag) {
            return $this->success(translate('messages.update_success', ['name' => 'Tag']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Tag']));
        }
    }
    public function destroy($id)
    {
        $this->tagRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }
}
