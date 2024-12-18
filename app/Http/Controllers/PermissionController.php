<?php

namespace App\Http\Controllers;

use App\Helpers\ComHelper;
use App\Http\Resources\PermissionResource;
use App\Models\ComStore;
use App\Models\CustomPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public function getpermissions(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $shop_count=1; // Primarily Pass For All
        $permissions=null;
        if($user->activity_scope=='store_level') // Now Check if user is a Store User and he have assigned Stores
        {
            $shop_count=ComStore::where('merchant_id', $user->id)->count();
        }

        if($shop_count > 0) {
            $permissions = $user->rolePermissionsQuery()->whereNull('parent_id')->with('childrenRecursive')->get();
        } else{
            // Get specific permissions for non-store level users
            $permissions = $user->rolePermissionsQuery()
                ->whereIn('name', ['dashboard', 'Store Settings','/seller/store/list'])
                ->with(['children' => function ($query) {
                    $query->whereIn('name', ['dashboard', 'Store Settings', '/seller/store/list']);
                }])
                ->whereNull('parent_id') // Top-level permissions
                ->get();

            $permissions = $permissions->map(function ($permission) {
                // Check if options is a string and decode it into an array
                if (is_string($permission->options)) {
                    $permission->options = json_decode($permission->options, true);
                }

                // Recursively decode the options of children permissions (if any)
                if (!empty($permission->children)) {
                    $permission->children = collect($permission->children)->map(function ($child) {
                        if (is_string($child->options)) {
                            $child->options = json_decode($child->options, true);
                        }
                        return $child;
                    });
                }

                return $permission;
            });
        }


        return [
            "permissions" => ComHelper::buildMenuTree($user->roles()->pluck('id')->toArray(), $permissions),
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'email' => $user->email,
            'activity_scope' => $user->activity_scope,
        ];
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
