<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\StatusType;
use App\Exports\ProductExport;
use App\Helpers\MultilangSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Admin\ProductRequestResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Product\LowStockProductResource;
use App\Http\Resources\Product\OutOfStockProductResource;
use App\Http\Resources\Product\ProductListResource;
use App\Imports\ProductImport;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\ProductVariantInterface;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Subscription\app\Models\StoreSubscription;

class AdminProductManageController extends Controller
{
    public function __construct(protected ProductManageInterface $productRepo, protected ProductVariantInterface $variantRepo)
    {
    }

    public function index(Request $request)
    {
        $storeId = $request->store_id ?? '';
        $status = $request->status ?? '';
        $limit = $request->per_page ?? 10;
        $page = $request->page ?? 1;
        $locale = $request->language ?? 'en';
        $type = $request->type ?? '';
        $search = $request->search ?? '';
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sort ?? 'asc';
        $filters = [];

        $products = $this->productRepo->getPaginatedProduct(
            $storeId,
            $status,
            $limit,
            $page,
            $locale,
            $type,
            $search,
            $sortField,
            $sortOrder,
            $filters
        );

        return response()->json([
            'data' => ProductListResource::collection($products),
            'meta' => new PaginationResource($products)
        ]);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $slug = MultilangSlug::makeSlug(Product::class, $request->name, 'slug');
        $request['slug'] = $slug;
        $request['type'] = Store::where('id', $request['store_id'])->first()->store_type;
        $request['meta_keywords'] = json_encode($request['meta_keywords']);
        $request['warranty'] = json_encode($request['warranty']);
        $request['status'] = 'approved';
        // check store
        $store = Store::find($request->store_id);
        if (!$store) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        if ($store->subscription_type == 'commission') {
            $product = $this->productRepo->store($request->all());
        } else {
            // check the valid subscription limit for the store
            $validSubscription = $store->getValidSubscriptionByFeatureLimits(['product_limit' => 1]);

            if (!$validSubscription) {
                return response()->json([
                    'message' => __('messages.insufficient_limit')
                ], 422);
            }

            // check store subscription
            $storeSubscription = StoreSubscription::find($validSubscription['subscription_id']);

            if (!$storeSubscription) {
                return response()->json([
                    'message' => __('messages.store_subscription_no_active_not_found')
                ], 422);
            }

            // Proceed with update
            $product = $this->productRepo->store($request->all());

            // Safe decrement without going below zero
            $storeSubscription->update([
                'product_limit' => max(0, $storeSubscription->product_featured_limit - 1)
            ]);
        }
        createOrUpdateTranslation($request, $product, 'App\Models\Product', $this->productRepo->translationKeys());
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

    public function update(ProductRequest $request)
    {
        $request['meta_keywords'] = json_encode($request['meta_keywords']);
        $request['warranty'] = json_encode($request['warranty']);
        $product = $this->productRepo->update($request->all());
        createOrUpdateTranslation($request, $product, 'App\Models\Product', $this->productRepo->translationKeys());
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
            $filename = 'admin/product/' . $timestamp . '_' . $file->getClientOriginalName();
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
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'min_id' => 'nullable|integer|min:1',
            'max_id' => 'nullable|integer|min:1|gte:min_id',
            'format' => 'nullable|string|in:csv,xlsx', // Allow file format selection
            'export_without_data' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 422,
                'message' => $validator->errors(),
            ]);
        }

        try {
            // Define common variables
            $exportWithoutData = $request->input('export_without_data', false);
            $selectedShopIds = (array)$request->input('store_ids', []);
            $selectedProductIds = (array)$request->input('product_ids', []);
            $startDate = $request->input('start_date'); // e.g., '2025-01-01'
            $endDate = $request->input('end_date');     // e.g., '2025-01-09'
            $minId = $request->input('min_id');         // Minimum product ID
            $maxId = $request->input('max_id');         // Maximum product ID
            $format = $request->input('format', 'xlsx'); // Default to 'xlsx' if not provided
            $fileName = 'products_' . time() . '.' . $format;

            // Default export with all filters applied
            return Excel::download(new ProductExport(
                $selectedShopIds,
                $selectedProductIds,
                $startDate,
                $endDate,
                $minId,
                $maxId,
                $exportWithoutData
            ), $fileName, $format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX);

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
            $lowStockProducts = Product::lowStock()->with(['store.related_translations', 'related_translations'])->paginate(10);
            return response()->json([
                'data' => LowStockProductResource::collection($lowStockProducts),
                'meta' => new PaginationResource($lowStockProducts),
            ]);
        } elseif ($request->stock_type == 'out_of_stock') {
            $outOfStockProducts = Product::outOfStock()->with(['store.related_translations', 'related_translations'])->paginate(10);
            return response()->json([
                'data' => OutOfStockProductResource::collection($outOfStockProducts),
                'meta' => new PaginationResource($outOfStockProducts),
            ]);
        } else {
            $lowStockProducts = Product::lowStock()->with(['store.related_translations', 'related_translations'])->paginate(10);
            return response()->json([
                'data' => LowStockProductResource::collection($lowStockProducts),
                'meta' => new PaginationResource($lowStockProducts),
            ]);
        }
    }

    public function productRequests()
    {
        $products = $this->productRepo->getPendingProducts();
        return response()->json([
            'data' => ProductRequestResource::collection($products),
            'meta' => new PaginationResource($products),
        ]);

    }

    public function approveProductRequests(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_ids*' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $success = $this->productRepo->approvePendingProducts($request->product_ids);
        if ($success) {
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Products status']),
            ]);
        } else {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Products status']),
            ], 500);
        }
    }

    public function addToFeatured(Request $request)
    {
        // check product exists
        $product = Product::where('id', $request->id)
            ->where('status', 'approved')
            ->whereNull('deleted_at')
            ->first();
        if (!$product) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }

        // check if the product is already featured
        if ($product->is_featured) {
            $product->update([
                'is_featured' => false
            ]);
            return response()->json([
                'messages' => __('messages.product_featured_removed_successfully')
            ]);
        }

        // check store
        $store = Store::find($product->store_id);
        if (!$store) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }

        if ($store->subscription_type == 'commission') {
            // Proceed with update
            $product->update(['is_featured' => true]);
        } else {
            // check the valid subscription limit for the store
            $validSubscription = $store->getValidSubscriptionByFeatureLimits(['product_featured_limit' => 1]);

            if (!$validSubscription) {
                return response()->json([
                    'message' => __('messages.insufficient_limit')
                ], 422);
            }

            // check store subscription
            $storeSubscription = StoreSubscription::find($validSubscription['subscription_id']);

            if (!$storeSubscription) {
                return response()->json([
                    'message' => __('messages.store_subscription_no_active_not_found')
                ], 422);
            }

            // Proceed with update
            $product->update(['is_featured' => true]);

            // Safe decrement without going below zero
            $storeSubscription->update([
                'product_featured_limit' => max(0, $storeSubscription->product_featured_limit - 1)
            ]);
        }

        return response()->json([
            'message' => __('messages.product_featured_added_successfully')
        ], 200);
    }
}
