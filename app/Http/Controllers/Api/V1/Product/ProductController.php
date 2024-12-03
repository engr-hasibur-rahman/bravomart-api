<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Helpers\MultilangSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Interfaces\ProductManageInterface;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductManageInterface $productRepo) {}
    public function index(Request $request)
    {
        return $this->productRepo->getPaginatedProduct(
            $request->limit ?? 10,
            $request->page ?? 1,
            app()->getLocale() ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
    }
    public function store(ProductRequest $request): JsonResponse
    {
        $slug = MultilangSlug::
        $product = $this->productRepo->store($request->all());
        $this->productRepo->storeTranslation($request, $product, 'App\Models\Product', $this->productRepo->translationKeys());
        
        if ($product) {
            return $this->success(translate('messages.save_success', ['name' => 'Product']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'product']));
        }
    }
    public function show(Request $request)
    {
        return $this->productRepo->getProductById($request->id);
    }
    public function update(ProductRequest $request)
    {
        $product = $this->productRepo->update($request->all());
        if ($product) {
            return $this->success(translate('messages.update_success', ['name' => 'Tag']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Tag']));
        }
    }
    public function destroy($id)
    {
        $this->productRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }
}
