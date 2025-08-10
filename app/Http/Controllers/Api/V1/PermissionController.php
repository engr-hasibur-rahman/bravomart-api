<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PermissionKey;
use App\Helpers\ComHelper;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\SellerRoleResource;
use App\Models\CustomPermission;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionController extends Controller
{
    public function getpermissions(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $roleIds = $user->roles()->pluck('id');
        $shop_count = 1; // Primarily Pass For All
        $permissions = null;
        // Now Check if user is a Store User and he have assigned Stores
        if ($user->activity_scope == 'store_level') {
            $shop_count = Store::where('store_seller_id', $user->id)->count();
        }

        if ($shop_count > 0) {
            // Handle permissions for any route under "seller/store/"
            if ($user->activity_scope == 'store_level' && !empty($request->store_slug)) {
                $permissions = $user->rolePermissionsQuery() // Start from permissions assigned to the user's roles
                ->whereNull('parent_id') // Fetch only top-level (root) permissions (i.e., no parent)
                ->with([
                    // Eager load children recursively, but only if those children are assigned to the user's roles
                    'childrenRecursive' => function ($query) use ($roleIds) {
                        $query->whereHas('roles', function ($q) use ($roleIds) {
                            // Filter to include only permissions that are assigned to the user's roles
                            $q->whereIn('role_id', $roleIds);
                        })->with([
                            // Now for each child, load their children (grandchildren) recursively,
                            // again only if assigned to the user's roles
                            'childrenRecursive' => function ($subQuery) use ($roleIds) {
                                $subQuery->whereHas('roles', function ($q) use ($roleIds) {
                                    $q->whereIn('role_id', $roleIds);
                                });
                            }]);
                    }
                ])
                    ->get(); // Finally, execute the query and get the results
            } elseif ($user->activity_scope == 'store_level' && empty($request->store_slug)) {
                $permissionsArray = [
                    'dashboard',
                    PermissionKey::SELLER_STORE_MY_SHOP->value,
                ];

                // Get only the permissions listed
                $permissions = $user->rolePermissionsQuery()
                    ->whereIn('name', $permissionsArray)
                    ->get()
                    ->map(function ($permission) {
                        // Decode options if it's a string
                        if (is_string($permission->options)) {
                            $permission->options = json_decode($permission->options, true);
                        }

                        // Add type info
                        $permission->type = $permission->parent_id === null ? 'parent' : 'child';

                        return $permission;
                    });

                // Identify parent and child
                $parents = $permissions->filter(fn($p) => $p->parent_id === null)->keyBy('id');
                $children = $permissions->filter(fn($p) => $p->parent_id !== null);

                // Attach children only if their parent exists in the list
                foreach ($children as $child) {
                    if ($parents->has($child->parent_id)) {
                        $child->type = 'child';
                        $parents[$child->parent_id]->children[] = $child;
                    }
                }

                // Result: parent with children (if both in array), and also track type
                $result = $permissions->map(function ($permission) use ($parents) {
                    $permission->type = $permission->parent_id === null ? 'parent' : 'child';
                    return $permission;
                });

            } elseif ($user->activity_scope == 'system_level') {
                $permissions = $user->rolePermissionsQuery() // Start from permissions assigned to the user's roles
                ->whereNull('parent_id') // Fetch only top-level (root) permissions (i.e., no parent)
                ->with([
                    // Eager load children recursively, but only if those children are assigned to the user's roles
                    'childrenRecursive' => function ($query) use ($roleIds) {
                        $query->whereHas('roles', function ($q) use ($roleIds) {
                            // Filter to include only permissions that are assigned to the user's roles
                            $q->whereIn('role_id', $roleIds);
                        })->with([
                            // Now for each child, load their children (grandchildren) recursively,
                            // again only if assigned to the user's roles
                            'childrenRecursive' => function ($subQuery) use ($roleIds) {
                                $subQuery->whereHas('roles', function ($q) use ($roleIds) {
                                    $q->whereIn('role_id', $roleIds);
                                });
                            }]);
                    }
                ])->get(); // Finally, execute the query and get the results
            } else {
                // Define the permissions array for non-store level seller
                $permissionsArray = [
                    'dashboard',
                    'Store Settings',
                    PermissionKey::SELLER_STORE_MY_SHOP->value,
                    'Staff control',
                    PermissionKey::SELLER_STORE_STAFF_MANAGE->value,
                ];

                // Get specific permissions for non-store level users
                $permissions = $user->rolePermissionsQuery()
                    ->whereIn('name', $permissionsArray)
                    ->whereNull('parent_id') // Top-level permissions
                    ->with(['children' => function ($query) use ($permissionsArray) {
                        $query->whereIn('name', $permissionsArray);
                    }])
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

        } else {
            $permissionsArray = [
                'dashboard',
                PermissionKey::SELLER_STORE_MY_SHOP->value,
            ];

            // Get only the permissions listed
            $permissions = $user->rolePermissionsQuery()
                ->whereIn('name', $permissionsArray)
                ->get()
                ->map(function ($permission) {
                    // Decode options if it's a string
                    if (is_string($permission->options)) {
                        $permission->options = json_decode($permission->options, true);
                    }

                    // Add type info
                    $permission->type = $permission->parent_id === null ? 'parent' : 'child';

                    return $permission;
                });

            // Identify parent and child
            $parents = $permissions->filter(fn($p) => $p->parent_id === null)->keyBy('id');
            $children = $permissions->filter(fn($p) => $p->parent_id !== null);

            // Attach children only if their parent exists in the list
            foreach ($children as $child) {
                if ($parents->has($child->parent_id)) {
                    $child->type = 'child';
                    $parents[$child->parent_id]->children[] = $child;
                }
            }

            // Result: parent with children (if both in array), and also track type
            $permissions->map(function ($permission) use ($parents) {
                $permission->type = $permission->parent_id === null ? 'parent' : 'child';
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

    public
    function getRoles(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $roles = collect();
        if ($user->activity_scope === 'store_level') {
            $roles = Role::where('available_for', 'store_level')
                ->where('status', 1)
                ->get();
        }
        return [
            'id' => $user->id,
            'activity_scope' => $user->activity_scope,
            'roles' => SellerRoleResource::collection($roles),
        ];
    }

    public
    function index(Request $request)
    {

        $limit = $request->limit ?? 10;
        $permissions = QueryBuilder::for(PermissionKey::class)
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->paginate($limit);
        return PermissionResource::collection($permissions);
    }

    public
    function moduleWisePermissions(Request $request)
    {
        $permissions = QueryBuilder::for(CustomPermission::class)
            ->when($request->filled('available_for'), function (Builder $query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->whereNull('parent_id') // Start with top-level permissions
            ->with('childrenRecursive') // Include recursive children
            ->get();
        return ComHelper::buildMenuTree([0], $permissions);
    }

    public
    function permissionForStoreOwner(Request $request)
    {
        $permission = PermissionKey::findOrFail($request->id);
        $permission->available_for = $permission->available_for === 'system_level' ? 'store_level' : 'system_level';
        $permission->save();
        return response()->json([
            'success' => true,
            'message' => 'PermissionKey for Store Admin toggled successfully',
            'status' => $permission
        ]);
    }
}
