<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Helpers\MultilangSlug;
use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\ProductVariantRequest;
use App\Interfaces\ProductVariantInterface;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function __construct(protected ProductVariantInterface $productVariantRepo) {}
    public function index(Request $request)
    {
        return $this->productVariantRepo->getPaginatedVariant(
            $request->limit ?? 10,
            $request->page ?? 1,
            app()->getLocale() ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
    }
    public function store(ProductVariantRequest $request): JsonResponse
    {
        $variant_slug = MultilangSlug::makeSlug(ProductVariant::class, $request->variant_slug, 'variant_slug');
        $request['variant_slug'] = $variant_slug;
        // Generate a SKU without a prefix
        $sku = generateUniqueSku();
        $request['sku'] = $sku;
        $variant = $this->productVariantRepo->store($request->all());

        if ($variant) {
            return $this->success(translate('messages.save_success', ['name' => 'Vairant']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Vairant']));
        }
    }
    public function show(Request $request)
    {
        return $this->productVariantRepo->getVariantById($request->id);
    }
    public function update(ProductVariantRequest $request)
    {
        $variant = $this->productVariantRepo->update($request->all());
        if ($variant) {
            return $this->success(translate('messages.update_success', ['name' => 'Vairant']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Vairant']));
        }
    }
    public function destroy($id)
    {
        $this->productVariantRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }
    public function deleted_records(){
        $records = $this->productVariantRepo->records(true);

        return response ()->json([
            "data"=> $records,
            "massage" => "Records were restored successfully!"
        ],201);
    }
}
