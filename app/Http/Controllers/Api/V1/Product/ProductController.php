<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\StatusType;
use App\Enums\StoreType;
use App\Exports\ProductExport;
use App\Helpers\MultilangSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductVariantRequest;
use App\Imports\ProductImport;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\ProductVariantInterface;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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
            $selectedShopIds = (array) $request->input('store_ids', []);
            $selectedProductIds = (array) $request->input('product_ids', []);

            $fileName = 'products_' . time() . '.xlsx';

            return Excel::download(new ProductExport($selectedShopIds, $selectedProductIds), $fileName);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Export failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
