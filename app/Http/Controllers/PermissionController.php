<?php

namespace App\Http\Controllers;

use App\Helpers\ComHelper;
use App\Http\Resources\PermissionResource;
use App\Models\CustomPermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;


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

    public function moduleWisePermissions(Request $request)
    {
        $permissions = QueryBuilder::for(Permission::class)
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->get()
            ->groupBy('module');

        $permissions = QueryBuilder::for(CustomPermission::class)
            ->when($request->filled('available_for'), function (Builder $query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->whereNull('parent_id') // Start with top-level permissions
            ->with('childrenRecursive') // Include recursive children
            ->get();
        return  ComHelper::buildMenuTree([0],$permissions);
        //return PermissionResource::collection($permissions);
    }


    public function permissionForStoreOwner(Request $request)
    {
        $permission = Permission::findOrFail($request->id);
        $permission->available_for = $permission->available_for === 'system_level' ? 'store_level' : 'system_level';
        $permission->save();
        return response()->json([
            'success' => true,
            'message' => 'Permission for store owner toggled successfully',
            'status' => $permission
        ]);
    }
}
