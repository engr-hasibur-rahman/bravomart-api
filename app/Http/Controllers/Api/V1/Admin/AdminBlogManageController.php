<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helpers\MultilangSlug;
use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\Admin\AdminBlogCategoryDetailsResource;
use App\Http\Resources\Admin\AdminBlogCategoryListResource;
use App\Http\Resources\Admin\AdminBlogCategoryResource;
use App\Http\Resources\Admin\AdminBlogDetailsResource;
use App\Http\Resources\Admin\AdminBlogResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\BlogManageInterface;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminBlogManageController extends Controller
{
    public function __construct(protected BlogManageInterface $blogRepo)
    {
    }

    public function blogCategoryIndex(Request $request)
    {
        $blog_categories = $this->blogRepo->getPaginatedCategory(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? 'en',
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
        return response()->json([
            'data' => AdminBlogCategoryResource::collection($blog_categories),
            'meta' => new PaginationResource($blog_categories)
        ]);
    }

    public function blogCategoryStore(Request $request): JsonResponse
    {
        $request['slug'] = MultilangSlug::makeSlug(BlogCategory::class, $request->name, 'slug');
        try {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:blog_categories,name',
                'slug' => 'nullable|unique:blog_categories,slug',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'status_code' => 400,
                    'message' => $validator->errors()
                ]);
            }
            $request['status'] = isset($request->status) ? $request->status : 1;
            $category = $this->blogRepo->store($request->all(), BlogCategory::class);
            createOrUpdateTranslation($request, $category, 'App\Models\BlogCategory', $this->blogRepo->translationKeysForCategory());

            if ($category) {
                return $this->success(translate('messages.save_success', ['name' => 'Blog Category']));
            } else {
                return $this->failed(translate('messages.save_failed', ['name' => 'Blog Category']));
            }
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json([
                'success' => false,
                'message' => translate('messages.validation_failed', ['name' => 'Blog Category']),
                'errors' => $validationException->errors(),
            ], 422);
        }
    }

    public function blogCategoryUpdate(Request $request)
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
            $category = $this->blogRepo->update($request->all(), BlogCategory::class);
            createOrUpdateTranslation($request, $category, 'App\Models\BlogCategory', $this->blogRepo->translationKeysForCategory());
            if ($category) {
                return $this->success(translate('messages.update_success', ['name' => 'Blog Category']));
            } else {
                return $this->failed(translate('messages.update_failed', ['name' => 'Blog Category']));
            }
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json([
                'success' => false,
                'message' => translate('messages.validation_failed', ['name' => 'Blog Category']),
                'errors' => $validationException->errors(),
            ], 422);
        }
    }

    public function blogCategoryShow(Request $request)
    {
        $blog_category = $this->blogRepo->getCategoryById($request->id);
        if ($blog_category) {
            return response()->json(new AdminBlogCategoryDetailsResource($blog_category));
        } else {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
    }

    public function blogCategoryDestroy($id)
    {
        $this->blogRepo->delete($id, BlogCategory::class);
        return $this->success(translate('messages.delete_success'));
    }

    public function blogIndex(Request $request)
    {
        $blogs = $this->blogRepo->getPaginatedBlog(
            $request->per_page ?? 10,
            $request->page ?? 1,
            $request->language ?? 'en',
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
        return response()->json([
            'data' => AdminBlogResource::collection($blogs),
            'meta' => new PaginationResource($blogs)
        ], 200);
    }

    public function blogShow(Request $request)
    {
        $blog = $this->blogRepo->getBlogById($request->id);
        if ($blog) {
            return response()->json(new AdminBlogDetailsResource($blog), 200);
        } else {
            return response()->json([
                'message' => __('message.data_not_found')
            ], 404);
        }
    }

    public function blogStore(BlogRequest $request): JsonResponse
    {
        $request['slug'] = MultilangSlug::makeSlug(Blog::class, $request->title, 'slug');
        $request['admin_id'] = auth('api')->user()->id;
        try {
            $blog = $this->blogRepo->store($request->all(), Blog::class);
            createOrUpdateTranslation($request, $blog, 'App\Models\Blog', $this->blogRepo->translationKeysForBlog());
            if ($blog) {
                return $this->success(translate('messages.save_success', ['name' => 'Blog']));
            } else {
                return $this->failed(translate('messages.save_failed', ['name' => 'Blog']));
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function blogUpdate(BlogRequest $request): JsonResponse
    {
        try {
            $blog = $this->blogRepo->update($request->all(), Blog::class);
            createOrUpdateTranslation($request, $blog, 'App\Models\Blog', $this->blogRepo->translationKeysForBlog());
            if ($blog) {
                return $this->success(translate('messages.update_success', ['name' => 'Blog']));
            } else {
                return $this->failed(translate('messages.update_failed', ['name' => 'Blog']));
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function blogDestroy($id)
    {
        $this->blogRepo->delete($id, Blog::class);
        return $this->success(translate('messages.delete_success'));
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:blogs,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try {
            $blog = Blog::find($request->id);
            if (!$blog) {
                return response()->json([
                    'message' => __('messages.data_not_found')
                ], 404);
            }
            $blog->updateOrFail([
                'status' => !$blog->status
            ]);

            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Blog status']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Blog status']),
            ], 500);
        }
    }

    public function categoryStatusChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:blog_categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $category = BlogCategory::find($request->id);
        if ($category) {
            $category->updateOrFail([
                'status' => !$category->status
            ]);
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Blog Category']),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
    }

    public function blogCategoryList()
    {
        $category = BlogCategory::all();
        return response()->json(AdminBlogCategoryListResource::collection($category));
    }
}
