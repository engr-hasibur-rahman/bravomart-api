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
        ->paginate($limit);
        return PermissionResource::collection($permissions);

    }


    public function permissionForStoreOwner(Request $request)
    {
        $permission = Permission::findOrFail($request->id);
        $permission->available_for = $request->available_for;
        $permission->save();
        return response()->json([
            'success' => true,
            'message' => 'Product brand status updated successfully',
            'status' => $permission
        ]);
    }
}
