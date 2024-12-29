<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helpers\MultilangSlug;
use App\Http\Controllers\Controller;
use App\Interfaces\PageManageInterface;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesManageController extends Controller
{
    public function __construct(protected PageManageInterface $pageRepo)
    {
    }

    public function pagesIndex(Request $request)
    {
        return $this->pageRepo->getPaginatedCategory(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? 'en',
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
    }

    public function pagesStore(Request $request): JsonResponse
    {
        $request['slug'] = MultilangSlug::makeSlug(Page::class, $request->name, 'slug');
        try {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:pages,name',
                'slug' => 'nullable|unique:pages,slug',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'status_code' => 400,
                    'message' => $validator->errors()
                ]);
            }
            $category = $this->pageRepo->store($request->all(), Page::class);
            $this->pageRepo->storeTranslation($request, $category, 'App\Models\Page', $this->pageRepo->translationKeysForCategory());

            if ($category) {
                return $this->success(translate('messages.save_success', ['name' => 'Page']));
            } else {
                return $this->failed(translate('messages.save_failed', ['name' => 'Page']));
            }
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json([
                'success' => false,
                'message' => translate('messages.validation_failed', ['name' => 'Page']),
                'errors' => $validationException->errors(),
            ], 422);
        }
    }

    public function pagesUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:blog_categories,name,' . $request->id,
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'status_code' => 400,
                    'message' => $validator->errors()
                ]);
            }
            $category = $this->pageRepo->update($request->all(), Page::class);
            $this->pageRepo->updateTranslation($request, $category, 'App\Models\Page', $this->pageRepo->translationKeysForCategory());
            if ($category) {
                return $this->success(translate('messages.update_success', ['name' => 'Page']));
            } else {
                return $this->failed(translate('messages.update_failed', ['name' => 'Page']));
            }
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json([
                'success' => false,
                'message' => translate('messages.validation_failed', ['name' => 'Page']),
                'errors' => $validationException->errors(),
            ], 422);
        }
    }

    public function pagesShow(Request $request)
    {
        return $this->pageRepo->getCategoryById($request->id);
    }

    public function pagesDestroy($id)
    {
        $this->pageRepo->delete($id, Page::class);
        return $this->success(translate('messages.delete_success'));
    }

}
