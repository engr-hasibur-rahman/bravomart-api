<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\Permission;
use App\Enums\Role as UserRole;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PartnerLoginController extends Controller
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('activity_scope', 'STORE_AREA')->where('is_active', true)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["success" => false,"token" => null, "permissions" => []];
        }
        $email_verified = $user->hasVerifiedEmail();

        $rolse = json_decode($user->perm_roles);
        //$permissions = Role::whereIn('name', $rolse)->with('permissions')->get();
        $permissions = [];
        $permissions = $user->permissions->pluck('name')->toArray();

        foreach ($user->roles as $role) {
            $permissions = array_merge($permissions, $role->permissions->pluck('name')->toArray());
        }
                
        return [
            "success" => true,
            "token" => $user->createToken('auth_token')->plainTextToken,
            "permissions" => $permissions,
            "email_verified" => $email_verified,
            "role" => $user->getRoleNames()
        ];
    }

}
