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
        createOrUpdateTranslation($request, $menu->id, 'App\Models\Menu', $this->translationKeys());
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
        createOrUpdateTranslation($request, $menu->id, 'App\Models\Menu', $this->translationKeys());
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
}
