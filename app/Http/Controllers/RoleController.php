<?php

namespace App\Http\Controllers;

use App\Helpers\ComHelper;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
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

        logger($request->permissions);
        $roleId = $request->input('id');

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
            $role->syncPermissions($request->permissions);
        }

        return response()->json('roles added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$role = CustomRole::with(['permissions.childrenRecursive'])->whereNull('parent_id')->findOrFail($id);
        $role = CustomRole::with([
            'permissions' => function ($query) {
                $query->whereNull('parent_id')->with('childrenRecursive');
            }
        ])->findOrFail($id);

        $role2 = CustomRole::with([
            'permissions', // Eager-load the permissions relationship
            'childrenRecursive.permissions' => function ($query) {
                // Apply condition to the permissions of the children
                $query->whereNull('parent_id')->with('childrenRecursive');
            },
        ])->findOrFail($id);

       $permissions = $role->permissions;

        return [
            "id" => $role->id,
            "available_for" => $role->available_for,
            "name" => $role->name,
            "guard_name" => $role->guard_name,
            "permissions" => ComHelper::buildMenuTree([$role->id],$permissions)
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
