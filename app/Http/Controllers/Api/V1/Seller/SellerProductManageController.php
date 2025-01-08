<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Enums\StatusType;
use App\Exports\ProductExport;
use App\Helpers\MultilangSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Product\LowStockProductResource;
use App\Http\Resources\Product\OutOfStockProductResource;
use App\Http\Resources\Product\ProductListResource;
use App\Imports\ProductImport;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\ProductVariantInterface;
use App\Models\ComMerchantStore;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class SellerProductManageController extends Controller
{
    public function __construct(protected ProductManageInterface $productRepo, protected ProductVariantInterface $variantRepo)
    {
    }

    public function index(Request $request)
    {
        $storeId = $request->store_id ?? '';
        $limit = $request->limit ?? 10;
        $page = $request->page ?? 1;
        $locale = app()->getLocale() ?? DEFAULT_LANGUAGE;
        $search = $request->search ?? '';
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sort ?? 'asc';
        $filters = [];

        $products = $this->productRepo->getPaginatedProduct(
            $storeId,
            $limit,
            $page,
            $locale,
            $search,
            $sortField,
            $sortOrder,
            $filters
        );

        return ProductListResource::collection($products);
    }

    public function store(Request $request): JsonResponse
    {
        $slug = MultilangSlug::makeSlug(Product::class, $request->name, 'slug');
        $request['slug'] = $slug;
        $request['type'] = ComMerchantStore::where('id', $request['store_id'])->first()->store_type;
        $request['meta_keywords'] = json_encode($request['meta_keywords']);
        $product = $this->productRepo->store($request->all());
        $this->productRepo->storeTranslation($request, $product, 'App\Models\Product', $this->productRepo->translationKeys());
        if ($product) {
            return $this->success(translate('messages.save_success', ['name' => 'Product']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'product']));
        }
    }

    public function show($slug)
    {
        return $this->productRepo->getProductBySlug($slug);
    }

    public function update(Request $request)
    {
        $request['meta_keywords'] = json_encode($request['meta_keywords']);
        $product = $this->productRepo->update($request->all());
        $this->productRepo->updateTranslation($request, $product, 'App\Models\Product', $this->productRepo->translationKeys());
        if ($product) {
            return $this->success(translate('messages.update_success', ['name' => 'Product']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Product']));
        }
    }

    public function destroy($id)
    {
        $product = Product::findorfail($id);
        if ($product) {
            $product->delete();
            return $this->success(translate('messages.delete_success'));
        } else {
            return $this->failed(translate('messages.delete_failed'));
        }
    }

    public function deleted_records()
    {

        $records = $this->productRepo->records(true);
        return response()->json([
            "data" => $records,
            "massage" => "Records were restored successfully!"
        ], 201);
    }

    /* Change product status (Admin only) */
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

    /* Bulk product import */
    public function import(ImportRequest $request)
    {
        try {
            $file = $request->file('file');

            if (!$file) {
                return response()->json([
                    'status' => false,
                    'message' => translate('import.file.not.found', ['name' => 'Products']),
                ], 422);
            }
            Excel::import(new ProductImport, $file);
            // Generate a filename with a timestamp
            $timestamp = now()->timestamp;
            $filename = 'seller/product/' . $timestamp . '_' . $file->getClientOriginalName();
            // Save the uploaded file to private storage
            Storage::disk('import')->put($filename, file_get_contents($file));
            return response()->json([
                'status' => true,
                'message' => translate('import.success', ['name' => 'Products']),
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $exception->errors(),  // This accesses the errors properly
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /* Product export (all and both shop wise and product wise) */
    public function export(Request $request)
    {
        try {
            // Get selected shop IDs and product IDs from the request
            $selectedShopIds = (array)$request->input('store_ids', []);
            $selectedProductIds = (array)$request->input('product_ids', []);

            $fileName = 'products_' . time() . '.xlsx';

            return Excel::download(new ProductExport($selectedShopIds, $selectedProductIds), $fileName);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Export failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function lowOrOutOfStockProducts(Request $request)
    {
        if ($request->stock_type == 'low_stock') {
            $lowStockProducts = Product::lowStock()->with('store')->paginate(10);
            return response()->json([
                'data' => LowStockProductResource::collection($lowStockProducts),
                'meta' => new PaginationResource($lowStockProducts),
            ]);
        } elseif ($request->stock_type == 'out_of_stock') {
            $outOfStockProducts = Product::outOfStock()->with('store')->paginate(10);
            return response()->json([
                'data' => OutOfStockProductResource::collection($outOfStockProducts),
                'meta' => new PaginationResource($outOfStockProducts),
            ]);
        } else {
            $lowStockProducts = Product::lowStock()->with('store')->paginate(10);
            return response()->json([
                'data' => LowStockProductResource::collection($lowStockProducts),
                'meta' => new PaginationResource($lowStockProducts),
            ]);
        }

    }


}
