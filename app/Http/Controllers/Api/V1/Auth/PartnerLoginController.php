<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\Permission;
use App\Enums\Role as UserRole;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\ComStore;
use App\Models\User;
use App\Models\ComMerchant;
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
use function Laravel\Prompts\select;

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

        $user = User::where('email', $request->email)->where('activity_scope', 'store_level')->where('is_active', true)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["success" => false,"token" => null, "permissions" => []];
        }
        $email_verified = $user->hasVerifiedEmail();

        //$merchant = ComMerchant::where('user_id',$user->id)->first();
        $permissions = [];
        //Take Individual Permission
        $permissions_indv = $user->permissions->map(function ($permission) {
            return [
                'group' => $permission->module,
                'group_title' => $permission->module_title,
                'perm_name' => $permission->name,
                'perm_title' => $permission->perm_title,
            ];
        })->toArray();

        //Get Role Permission and Merge Them
        foreach ($user->roles as $role) {
            $permissions = array_merge($permissions_indv,$role->permissions->map(function ($permission) {
                return [
                    'group' => $permission->module,
                    'group_title' => $permission->module_title,
                    'perm_name' => $permission->name,
                    'perm_title' => $permission->perm_title,
                    ];
            })->toArray());
        }

        $stores = ComStore::whereIn('id', json_decode($user->stores))
            ->select(['id', 'name','store_type'])
            ->get()
            ->toArray();

        return [
            "success" => true,
            "token" => $user->createToken('auth_token')->plainTextToken,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email'    => $user->email,
            'phone'    => $user->phone,
            "email_verified" => $email_verified,
            "store_owner" => $user->store_owner,
            "merchant_id" => $user->merchant_id,
            "stores" => $stores,
            "permissions" => $permissions,
            "role" => $user->getRoleNames()
        ];
    }

}
