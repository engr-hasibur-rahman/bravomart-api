<?php

namespace App\Http\Controllers;

use App\Helpers\ComHelper;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\CustomPermission;
use App\Models\CustomRole;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $roles = QueryBuilder::for(Role::class)
            ->with(['permissions'])
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->paginate($limit);
        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {

        $roleId = $request->input('role_id');

        if ($roleId) {
            $role = Role::findOrFail($roleId);
            $role->update(['name' => $request->role_name, 'guard_name' => 'api']);
        } else {
            $role = Role::create([
                'name' => $request->role_name,
                'available_for' => $request->available_for,
                'guard_name' => 'api',
            ]);
        }

        if ($request->permissions) {
            $syncData = [];
            foreach ($request->permissions as $item) {
                $syncData[$item['id']] = [
                    'view' => $item['view'] ?? null, // Handle the `view` column if applicable
                    'insert' => $item['insert'] ?? null, // Handle the `insert` column if applicable
                    'update' => $item['update'] ?? null, // Handle the `update` column if applicable
                    'delete' => $item['delete'] ?? null, // Handle the `delete` column if applicable
                    'others' => $item['others'] ?? null, // Handle the `others` column if applicable
                ];
            }
            $role->permissions()->sync($syncData);
        }

        return response()->json('roles added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = CustomRole::with([
            'permissions' => function ($query) {
                $query->whereNull('parent_id')->with('childrenRecursive');
            }
        ])->findOrFail($id);

        // Load all permissions
        $allPermissions = CustomPermission::with('childrenRecursive')->where('available_for',$role->available_for)
            ->whereNull('parent_id') // Adjust condition based on your hierarchy
            ->get();

        // Mark permissions associated with the role
        $allPermissions = $allPermissions->map(function ($permission) use ($role) {
            $permission->is_assigned = $role->permissions->contains('id', $permission->id);
            return $permission;
        });


        return [
            "id" => $role->id,
            "available_for" => $role->available_for,
            "name" => $role->name,
            "guard_name" => $role->guard_name,
            "permissions" => ComHelper::buildMenuTree([$role->id],$allPermissions)
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();
        if (isset($request->permissions)) {
            $role->syncPermissions($request->permissions);
        }

        return $role;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json('Role deleted');
    }

    public function roleForStoreOwner(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $role->status = !$role->status;
        $role->save();
        return response()->json([
            'success' => true,
            'message' => 'Role Status changed successfully',
            'status' => $role
        ]);
    }
}
