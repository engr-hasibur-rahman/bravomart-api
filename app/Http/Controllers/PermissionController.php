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
        $permission = Permission::findOrFail($request->id);
        $permission->available_for = $permission->available_for === 'super_admin' ? 'store_owner' : 'super_admin';
        $permission->save();
        return response()->json([
            'success' => true,
            'message' => 'Permission for store owner toggled successfully',
            'status' => $permission
        ]);
    }
}
