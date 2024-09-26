<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $permissions = QueryBuilder::for(Permission::class)
        ->when($request->filled('available_for'), function ($query) use ($request) {
            $query->where('available_for', $request->available_for);
        })
        ->paginate($limit);
        return PermissionResource::collection($permissions);

    }


    public function permissionForStoreOwner(Request $request)
{
    // Find the permission by ID
    $permission = Permission::findOrFail($request->id);

    // Toggle between 'admin' and 'store_owner'
    if ($permission->available_for === 'super_admin') {
        $permission->available_for = 'store_owner';
    } elseif ($permission->available_for === 'store_owner') {
        $permission->available_for = 'super_admin';
    }

    // Save the updated permission
    $permission->save();

    // Return a response with the updated permission
    return response()->json([
        'success' => true,
        'message' => 'Permission for store owner toggled successfully',
        'status' => $permission
    ]);
}

}
