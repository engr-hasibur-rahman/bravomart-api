<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\StatusType;
use App\Enums\StoreType;
use App\Helpers\MultilangSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductVariantRequest;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\ProductVariantInterface;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductManageInterface $productRepo, protected ProductVariantInterface $variantRepo)
    {
    }

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
        $slug = MultilangSlug::makeSlug(Product::class, $request->name, 'slug');
        $request['slug'] = $slug;
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
            return $this->success(translate('messages.update_success', ['name' => 'Product']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Product']));
        }
    }

    public function destroy($id)
    {
        $this->productRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }

    public function deleted_records()
    {
        $records = $this->productRepo->records(true);
        return response()->json([
            "data" => $records,
            "massage" => "Records were restored successfully!"
        ], 201);
    }

    public function changeStatus(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|exists:products,id',
                'status' => 'required|in:' . implode(',', array_column(StatusType::cases(), 'value'))
            ]);
            $this->productRepo->changeStatus($validatedData);
            return $this->success(translate('messages.update_success', ['name' => 'Status']));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Return a failure response
            return $this->failed(translate('messages.update_failed', ['name' => 'Status']));
        }
    }
}
