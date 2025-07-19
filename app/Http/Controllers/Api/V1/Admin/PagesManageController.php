<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helpers\MultilangSlug;
use App\Http\Controllers\Api\V1\Controller;
use App\Interfaces\PageManageInterface;
use App\Models\Page;
use App\Models\Translation;
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
        return $this->pageRepo->getPaginatedPage(
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
        if (empty($request->slug) || $request->slug == null) {
            $request['slug'] = MultilangSlug::makeSlug(Page::class, $request->title, 'slug');
        }
        try {

            if ($request->slug === 'about'){
                $validatedData = $request->validate([
                    'content' => 'required|array',
                    'translations' => 'required|array',
                ]);

                // Update by ID
                $settings = Page::where('slug', 'about')->first();

                if ($settings) {
                    $settings->update([
                        'content' => json_encode($validatedData['content']),
                        'title' => 'About Page',
                    ]);
                } else {
                    $settings = Page::updateOrCreate(
                        ['slug' => 'about'],
                        [
                            'content' => json_encode($validatedData['content']),
                            'title' => 'About Page',
                            'status' => 'publish',
                        ]
                    );
                }

                foreach ($validatedData['translations'] as $translation) {
                    Translation::updateOrCreate(
                        [
                            'language' => $translation['language_code'],
                            'translatable_id' => $settings->id,
                            'translatable_type' => 'App\Models\Page',
                            'key' => 'content',
                        ],
                        [
                            'value' => json_encode($translation['content']),
                        ]
                    );
                }
            }


            if ($request->slug === 'contact'){
                $validatedData = $request->validate([
                    'content' => 'required|array',
                    'translations' => 'required|array',
                ]);

                // Update by ID
                $settings = Page::where('slug', 'contact')->first();

                if ($settings) {
                    $settings->update([
                        'content' => json_encode($validatedData['content']),
                        'title' => 'Contact Page',
                    ]);
                } else {
                    $settings = Page::updateOrCreate(
                        ['slug' => 'contact'], // Correct format
                        [
                            'content' => json_encode($validatedData['content']),
                            'title' => 'Contact Page',
                            'status' => 'publish',
                        ]
                    );
                }

                foreach ($validatedData['translations'] as $translation) {
                    Translation::updateOrCreate(
                        [
                            'language' => $translation['language_code'],
                            'translatable_id' => $settings->id,
                            'translatable_type' => 'App\Models\Page',
                            'key' => 'content',
                        ],
                        [
                            'value' => json_encode($translation['content']),
                        ]
                    );
                }
            }


            if ($request->slug === 'become_a_seller'){
                $validatedData = $request->validate([
                    'content' => 'required|array',
                    'translations' => 'required|array',
                ]);

                // Update by ID
                $settings = Page::where('slug', 'become_a_seller')->first();

                if ($settings) {
                    $settings->update([
                        'content' => json_encode($validatedData['content']),
                        'title' => 'Become A Seller',
                    ]);
                } else {
                    $settings = Page::updateOrCreate(
                        ['slug' => 'become_a_seller'],
                        [
                            'content' => json_encode($validatedData['content']),
                            'title' => 'Become A Seller',
                            'status' => 'publish',
                        ]
                    );
                }

                foreach ($validatedData['translations'] as $translation) {
                    Translation::updateOrCreate(
                        [
                            'language' => $translation['language_code'],
                            'translatable_id' => $settings->id,
                            'translatable_type' => 'App\Models\Page',
                            'key' => 'content',
                        ],
                        [
                            'value' => json_encode($translation['content']),
                        ]
                    );
                }
            }

            // Validate input data
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:pages,title',
                'slug' => 'required|unique:pages,slug',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'status_code' => 400,
                    'message' => $validator->errors()
                ]);
            }
            $page = $this->pageRepo->store($request->all(), Page::class);
            createOrUpdateTranslationJson($request, $page, 'App\Models\Page', $this->pageRepo->translationKeysForPage());

            if ($page) {
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
                'title' => 'required|unique:pages,title,' . $request->id,
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'status_code' => 400,
                    'message' => $validator->errors()
                ]);
            }
            $category = $this->pageRepo->update($request->all(), Page::class);
            createOrUpdateTranslationJson($request, $category, 'App\Models\Page', $this->pageRepo->translationKeysForPage());
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
        return $this->pageRepo->getPageById($request->id);
    }

    public function pagesDestroy($id)
    {
        $this->pageRepo->delete($id, Page::class);
        return $this->success(translate('messages.delete_success'));
    }

}
