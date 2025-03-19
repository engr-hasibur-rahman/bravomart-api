<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
            'icon' => 'nullable|string',
            'position' => 'required|integer',
            'is_visible' => 'required|boolean',
        ]);

        $menu = Menu::create($validated);

        return response()->json($menu, 201);
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
