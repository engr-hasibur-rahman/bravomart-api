<?php

namespace App\Http\Controllers;

use App\Helpers\ComHelper;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\SellerRoleResource;
use App\Models\ComMerchantStore;
use App\Models\CustomPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission as SpatiePermission; // Alias the Spatie PermissionKey model
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\PermissionKey; // Ensure you are importing your custom PermissionKey enum



class PermissionController extends Controller
{

    public function getpermissions(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $shop_count=1; // Primarily Pass For All
        $permissions=null;
        // Now Check if user is a Store User and he have assigned Stores
        if($user->activity_scope=='store_level')
        {
            $shop_count=ComMerchantStore::where('merchant_id', $user->id)->count();
        }

        if($shop_count > 0) {
            $permissions = $user->rolePermissionsQuery()->whereNull('parent_id')->with('childrenRecursive')->get();
        } else{

            // Define the permissions array for non-store level seller
            $permissionsArray = [
                'dashboard',
                'Store Settings',
                PermissionKey::STORE_MY_SHOP->value,
                'Staff control',
                PermissionKey::SELLER_STAFF_LIST->value,
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

    public function getRoles(Request $request)
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

    public function index(Request $request)
    {

        $limit = $request->limit ?? 10;
        $permissions = QueryBuilder::for(PermissionKey::class)
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->paginate($limit);
        return PermissionResource::collection($permissions);
    }

    public function moduleWisePermissions(Request $request)
    {
        $permissions = QueryBuilder::for(PermissionKey::class)
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
