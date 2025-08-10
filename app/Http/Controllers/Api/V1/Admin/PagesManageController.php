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
            if (in_array($request->slug, ['about', 'contact', 'become-a-seller'])) {
                // Validate input data

                $validatedData = Validator::make($request->all(), [
                    'title' => 'required|unique:pages,title',
                    'slug' => 'required|unique:pages,slug',
                    'about' => 'nullable|array',
                    'content' => 'nullable|array',
                    'become-a-seller' => 'nullable|array',
                    'translations' => 'nullable|array',
                ]);


                if ($validatedData->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => $validatedData->errors()
                    ],422);
                }
                $data = $validatedData->validated();

                $slug = $request->slug;
                // Dynamic title based on slug
                $page_title = match ($slug) {
                    'about' => 'About Page',
                    'contact' => 'Contact Page',
                    'become-a-seller' => 'Become A Seller',
                    default => 'Custom Page',
                };

                // Try to find page by slug
                $page = Page::where('slug', $slug)->first();


                if ($page) {
                    $page->update([
                        'content' => json_encode($data['content']),
                        'title' => $page_title,
                        'enable_builder' => 1,
                    ]);
                } else {
                    $page = Page::updateOrCreate(
                        ['slug' => $slug],
                        [
                            'content' => json_encode($data['content']),
                            'title' => $page_title,
                            'enable_builder' => 1,
                            'status' => 'publish',
                        ]
                    );
                }

                // Save translations
                if (isset($data['translations'])) {
                    foreach ($data['translations'] as $translation) {
                        Translation::updateOrCreate(
                            [
                                'language' => $translation['language_code'],
                                'translatable_id' => $page->id,
                                'translatable_type' => 'App\Models\Page',
                                'key' => 'content',
                            ],
                            [
                                'value' => json_encode($translation['content']),
                            ]
                        );
                    }
                }

                return $this->success(translate('messages.save_success', ['name' => 'Page']));
            }


            // Validate input data
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:pages,title',
                'slug' => 'required|unique:pages,slug',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ],422);
            }

        // Prepare input for storage
        $input = $request->all();

       // Convert content array to JSON string if necessary
        if (isset($input['content']) && is_array($input['content'])) {
            $input['content'] = json_encode($input['content']);
        }

        // Store page
        $page = $this->pageRepo->store($input, Page::class);

      // Save translations
        createOrUpdateTranslationJson($request, $page, 'App\Models\Page', $this->pageRepo->translationKeysForPage());

            if ($page) {
                return $this->success(translate('messages.save_success', ['name' => 'Page']));
            } else {
                return $this->failed(translate('messages.save_failed', ['name' => 'Page']),500);
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
                    'message' => $validator->errors()
                ],422);
            }
            $category = $this->pageRepo->update($request->all(), Page::class);
            createOrUpdateTranslationJson($request, $category, 'App\Models\Page', $this->pageRepo->translationKeysForPage());
            if ($category) {
                return $this->success(translate('messages.update_success', ['name' => 'Page']));
            } else {
                return $this->failed(translate('messages.update_failed', ['name' => 'Page']),500);
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
        return $this->pageRepo->getPageById($request->slug);
    }

    public function pagesDestroy($id)
    {
        $this->pageRepo->delete($id, Page::class);
        return $this->success(translate('messages.delete_success'));
    }

}
