<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role as UserRole;
use App\Http\Requests\UserCreateRequest;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\UserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $roles = QueryBuilder::for(User::class)
            ->with(['permissions'])
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->paginate($limit); 
        return UserResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        //dd($request->all());
        $notAllowedRoles = [UserRole::SUPER_ADMIN];
        if ((isset($request->roles->value) && in_array($request->roles->value, $notAllowedRoles)) || (isset($request->roles) && in_array($request->roles, $notAllowedRoles))) {
            throw new AuthorizationException(NOT_AUTHORIZED);
        }
        // By default role ---->
        $roles = Role::whereIn('available_for', ['store_level','fitter_level','delivery_level'])
        ->where('name', '!=', 'Store Owner')
        ->pluck('name');
        // If the role is given in request ---->
        if (isset($request->roles)) {
            $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
        }
        $user = $this->repository->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'slug' => username_slug_generator($request->first_name, $request->last_name),
            'email'    => $request->email,
            'phone'    => $request->phone,
            'status'    => 1,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($roles);

        return [
            "user" => $user,
            "permissions" => $user->getPermissionNames(),
            "role" => $user->getRoleNames()
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {     
        $user = User::with('permissions')->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function changestatus(int $id,int $is_active)
    {
        $roles = null;
        if (isset($request->roles)) {
            $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
        }
       
        $user = User::findOrFail($id);
        //$user->is_active =$is_active;
        $user->is_active = !$user->is_active;
        $user->save();

        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserCreateRequest $request)
    {
        $roles = null;
        if (isset($request->roles)) {
            $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
        }
       
        $user = User::findOrFail($request->id);
        $user->last_name =$request->last_name;
        $user->first_name =$request->first_name;
        $user->phone =$request->phone;
        $user->save();
        $user->syncRoles($roles);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
