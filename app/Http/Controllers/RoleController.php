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
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $roles = QueryBuilder::for(Role::class)
            ->with(['permissions'])
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->paginate($per_page);
        return RoleResource::collection($roles);
    }
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

        return response()->json([
            "message" => __('messages.save_success', ['name' => 'Role'])
        ], 201);
    }
    public function show(string $id)
    {
        $role = CustomRole::with([
            'permissions' => function ($query) {
                $query->whereNull('parent_id')->with('childrenRecursive');
            }
        ])->findOrFail($id);

        // Load all permissions
        $allPermissions = CustomPermission::with('childrenRecursive')->where('available_for', $role->available_for)
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
            "permissions" => ComHelper::buildMenuTree([$role->id], $allPermissions)
        ];
    }
    public function update(RoleRequest $request)
    {
        $role = Role::find($request->role_id);
        if ($role){
            $role->name = $request->role_name;
            $role->available_for = $request->available_for;
            $role->save();
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
            return $role;
        } else {
            return response()->json([
                "message" => __('messages.data_not_found')
            ],404);
        }
    }
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json('Role deleted');
    }

    public function changeStatus(Request $request)
    {
        $role = Role::find($request->id);
        if ($role){
            $role->status = !$role->status;
            $role->save();
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Role']),

            ],200);
        } else {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Role'])
            ],500);
        }

    }
}
