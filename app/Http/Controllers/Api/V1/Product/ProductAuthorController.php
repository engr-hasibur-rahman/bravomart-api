<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAuthorRequest;
use App\Interfaces\ProductAuthorInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductAuthorController extends Controller
{
    public function __construct(
        protected ProductAuthorInterface $authorRepo,
    ) {}
    public function index(Request $request)
    {
        return $this->authorRepo->getPaginatedAuthor(
            $request->limit ?? 10,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
        );
    }
    public function store(ProductAuthorRequest $request): JsonResponse
    {
        $author = $this->authorRepo->store($request->all());
        if ($author) {
            return $this->success(translate('messages.save_success', ['name' => 'Author']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Author']));
        }
    }
    public function show(Request $request){
        return $this->authorRepo->getAuthorById($request->id);
    }
    public function update(ProductAuthorRequest $request){
        $author = $this->authorRepo->update($request->all());
        if ($author) {
            return $this->success(translate('messages.update_success', ['name' => 'Author']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Author']));
        }
    }
    public function changeStatus(Request $request): JsonResponse
    {
        try {
            $this->authorRepo->changeStatus($request->all());
            return $this->success(translate('messages.status_change_success'));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_failed', ['name' => 'Author']));
        }
    }
    public function destroy($id){
        $this->authorRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }
}
