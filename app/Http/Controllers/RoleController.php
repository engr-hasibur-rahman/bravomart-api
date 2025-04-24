<?php

namespace App\Http\Controllers;

use App\Helpers\ComHelper;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
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
        $search = $request->search;
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sort ?? 'asc';
        $isPaginationDisabled = $request->has('pagination') && $request->pagination === "false";

        $roles = Role::with('permissions')
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortOrder);

        if ($isPaginationDisabled) {
            $roles = $roles->get();
            return response()->json([
                'roles' => RoleResource::collection($roles),
            ]);
        } else {
            $roles = $roles->paginate($per_page);
            return response()->json([
                'roles' => RoleResource::collection($roles),
                'meta' => new PaginationResource($roles),
            ]);
        }
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
        if ($role->locked){
            return response()->json([
                'message' => __('messages.role_can\'t_be_edited', ['reason' => 'This role is locked.'])
            ]);
        }
        if ($role) {
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
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        $user = auth('api')->user();
        if ($user->activity_scope == 'system_level') {
            $role = $user->roles()->pluck('id');
            if ($role->contains($id)) {
                return response()->json([
                    'message' => __('messages.role_can\'t_be_deleted', ['reason' => 'You are assigned to this role.'])
                ], 403);
            }
            $role = Role::findOrFail($id);
            if ($role->locked){
                return response()->json([
                    'message' => __('messages.role_can\'t_be_deleted', ['reason' => 'This role is locked.'])
                ]);
            }
            $permissions = $role->permissions;
            $role->delete();
            $role->permissions()->delete();
            return response()->json('Role deleted');
        } else {
            return response()->json([
                'message' => __('messages.role_can\'t_be_deleted', ['reason' => 'You are not allowed to delete this role.'])
            ], 403);
        }

    }

    public function changeStatus(Request $request)
    {
        $role = Role::find($request->id);
        if ($role->locked){
            return response()->json([
                'message' => __('messages.role_can\'t_be_edited', ['reason' => 'This role is locked.'])
            ]);
        }
        if ($role) {
            $role->status = !$role->status;
            $role->save();
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Role']),

            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Role'])
            ], 500);
        }

    }
}
