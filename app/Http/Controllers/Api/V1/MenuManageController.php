<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuManageController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_visible', true)->orderBy('position')->get();
        return response()->json($menus);
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
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
            'icon' => 'nullable|string',
            'position' => 'required|integer',
            'is_visible' => 'required|boolean',
        ]);

        $menu->update($validated);
        return response()->json($menu);
    }

    // Delete a menu item
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return response()->json(null, 204);
    }
}
