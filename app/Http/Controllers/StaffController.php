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
        $notAllowedRoles = [UserRole::SUPER_ADMIN];
        if ((isset($request->roles->value) && in_array($request->roles->value, $notAllowedRoles)) || (isset($request->roles) && in_array($request->roles, $notAllowedRoles))) {
            throw new AuthorizationException(NOT_AUTHORIZED);
        }
        $roles = [UserRole::CUSTOMER];
        if (isset($request->roles)) {
            $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
        }
        $user = $this->repository->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($roles);

        return [
            "user" => $user,
            "permissions" => $user->getPermissionNames(),
            "role" => $user->getRoleNames()->first()
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->repository->with(['translations'])->findOrFail($id);
        if ($category) {
            return new UserResource($category);
        }

        return response()->json(['error' => 'Product Brand not found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
