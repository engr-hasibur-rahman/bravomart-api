<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\MenuPublicViewResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuManageController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_visible', true)
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
        Menu::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Menu created successfully.',
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
        return response()->json([
            'status' => true,
            'message' => 'Menu updated successfully.',
        ]);
    }

    // Delete a menu item
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if (empty($menu)){
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
