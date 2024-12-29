<?php

namespace App\Http\Controllers\Api\V1\Blog;

use App\Helpers\MultilangSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\CommentRequest;
use App\Interfaces\BlogManageInterface;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogManageController extends Controller
{
    public function __construct(protected BlogManageInterface $blogRepo)
    {
    }

    /* <---------------------------------------------------Blog category start-----------------------------------------------------> */
    public function blogCategoryIndex(Request $request)
    {
        return $this->blogRepo->getPaginatedCategory(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? 'en',
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
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
            $category = $this->blogRepo->store($request->all(), BlogCategory::class);
            $this->blogRepo->storeTranslation($request, $category, 'App\Models\BlogCategory', $this->blogRepo->translationKeysForCategory());

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
            $validatedCategory = $request->validate([
                'id' => 'required',
                'name' => 'required',
            ]);
            $category = $this->blogRepo->update($validatedCategory, BlogCategory::class);
            $this->blogRepo->updateTranslation($request, $category, 'App\Models\BlogCategory', $this->blogRepo->translationKeysForCategory());
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
        return $this->blogRepo->getCategoryById($request->id);
    }

    public function blogCategoryDestroy($id)
    {
        $this->blogRepo->delete($id, BlogCategory::class);
        return $this->success(translate('messages.delete_success'));
    }
    /* <---------------------------------------------------Blog category end-----------------------------------------------------> */
    /* <---------------------------------------------------Blog start -----------------------------------------------------> */
    public function blogIndex(Request $request)
    {
        return $this->blogRepo->getPaginatedBlog(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? 'en',
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
    }

    public function blogShow(Request $request)
    {
        return $this->blogRepo->getBlogById($request->id);
    }

    public function blogStore(BlogRequest $request): JsonResponse
    {
        $request['slug'] = MultilangSlug::makeSlug(Blog::class, $request->title, 'slug');
        try {
            $blog = $this->blogRepo->store($request->all(), Blog::class);
            $this->blogRepo->storeTranslation($request, $blog, 'App\Models\Blog', $this->blogRepo->translationKeysForBlog());
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
            $this->blogRepo->updateTranslation($request, $blog, 'App\Models\Blog', $this->blogRepo->translationKeysForBlog());
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
    /* <---------------------------------------------------Blog end-----------------------------------------------------> */
    /* <---------------------------------------------------Comment start-----------------------------------------------------> */
    public function comment(CommentRequest $request)
    {
        try {
            if (!auth()->guard('api')->check()) {
                return unauthorized_response();
            } else {
                $userId = auth('api')->id();
                $request['user_id'] = $userId;
                BlogComment::create($request->all());
                return response()->json([
                    'status' => true,
                    'status_code' => 201,
                    'message' => __('messages.save_success', ['name' => 'Comment']),
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /* <---------------------------------------------------Comment end-----------------------------------------------------> */
}
