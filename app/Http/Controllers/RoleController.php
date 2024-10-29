<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
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

        $roleId = $request->input('id');

        if ($roleId) {
            $role = Role::findOrFail($roleId);
            $role->update(['name' => $request->role_name, 'guard_name' => 'api']);
        } else {
            $role = Role::create([
                'name' => $request->role_name,
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
        return QueryBuilder::for(Role::class)
            ->with(['permissions'])
            ->findOrFail($id);
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
