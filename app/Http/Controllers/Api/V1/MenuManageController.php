<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\MenuPublicDetailsResource;
use App\Http\Resources\MenuPublicViewResource;
use App\Models\Menu;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuManageController extends Controller
{
    public function __construct(protected Menu $menu, protected Translation $translation)
    {
    }

    public function translationKeys(): mixed
    {
        return $this->menu->translationKeys;
    }

    public function index()
    {
        $menus = Menu::with('related_translations')
            ->orderBy('position')
            ->paginate(10);

        return response()->json([
            'menus' => MenuPublicViewResource::collection($menus),
            'meta' => new PaginationResource($menus)
        ]);
    }

    // Create a new menu item
    public function store(Request $request)
    {

        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'position' => 'required|integer',
            'is_visible' => 'required|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 422);
        }
        // Use the validated data to create the menu item
        $menu = Menu::create($validator->validated());
        $this->createOrUpdateTranslation($request, $menu->id, 'App\Models\Menu', $this->translationKeys());
        return response()->json([
            'message' => __('messages.save_success', ['name' => 'Menu']),
        ]);
    }

    public function show(Request $request)
    {
        $menu = Menu::with(['related_translations'])->find($request->id);
        if (!$menu) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ]);
        }
        return response()->json([
            'data' => new MenuPublicDetailsResource($menu),
        ]);
    }


    // Update an existing menu item
    public function update(Request $request)
    {
        // Find the menu item by ID
        $menu = Menu::findOrFail($request->id);

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'position' => 'required|integer',
            'is_visible' => 'required|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ], 422);
        }

        $validated = $validator->validated();
        $menu->update($validated);
        $this->createOrUpdateTranslation($request, $menu->id, 'App\Models\Menu', $this->translationKeys());
        return response()->json([
            'message' => __('messages.update_success', ['name' => 'Menu']),
        ]);
    }

    // Delete a menu item
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if (empty($menu)) {
            return response()->json([
                'status' => false,
                'message' => 'Menu not found.',
            ], 404);
        }
        $menu->delete();
        return response()->json([
            'status' => true,
            'message' => 'Menu deleted successfully.',
        ]);
    }

    private function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        if (empty($request['translations'])) {
            return false;  // Return false if no translations are provided
        }

        $translations = [];
        foreach ($request['translations'] as $translation) {
            foreach ($colNames as $key) {
                // Fallback value if translation key does not exist
                $translatedValue = $translation[$key] ?? null;

                // Skip translation if the value is NULL
                if ($translatedValue === null) {
                    continue; // Skip this field if it's NULL
                }

                // Check if a translation exists for the given reference path, ID, language, and key
                $trans = $this->translation
                    ->where('translatable_type', $refPath)
                    ->where('translatable_id', $refid)
                    ->where('language', $translation['language_code'])
                    ->where('key', $key)
                    ->first();

                if ($trans) {
                    // Update the existing translation
                    $trans->value = $translatedValue;
                    $trans->save();
                } else {
                    // Prepare new translation entry for insertion
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }
        // Insert new translations if any
        if (!empty($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }
}
