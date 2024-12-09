<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Enums\Role as UserRole;
use App\Helpers\ComHelper;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use App\Models\Translation;
use App\Models\User;
use App\Models\ComMerchant;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function token(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        //->where('activity_scope', 'system_level')
        $user = User::where('email', $request->email)->where('activity_scope', 'system_level')->where('is_active', true)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["token" => null, "permissions" => []];
        }
        $email_verified = $user->hasVerifiedEmail();
        $permissions = $user->rolePermissionsQuery()->whereNull('parent_id')->with('childrenRecursive')->get();

        return [
            "token" => $user->createToken('auth_token')->plainTextToken,
            "permissions" => ComHelper::buildMenuTree($user->roles()->pluck('id')->toArray(), $permissions),
            "email_verified" => $email_verified,
            "role" => $user->getRoleNames()->first()
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function StoreOwnerRegistration(UserCreateRequest $request)
    {

        $roles = [UserRole::STORE_OWNER];
        $user = $this->repository->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'activity_scope'    => 'SHOP_AREA',
            'store_owner'    => 1,
        ]);

        $user->assignRole($roles);

        // Create Merchant ID for the user registered as BusinessMan. In future this will be create on User Approval
        $merchant = ComMerchant::create(['user_id' => $user->id]);
        // Keeping Merchant id in Users table. Though it is Bad concept: circular reference
        $user->merchant_id = $merchant->id;
        $user->save();


        return [
            'success' => true,
            "token" => $user->createToken('auth_token')->plainTextToken,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            "permissions" => $user->getPermissionNames(),
            "role" => $user->getRoleNames(),
            "store_owner" => $user->store_owner,
            "merchant_id" => $user->merchant_id,
            "stores" => json_decode($user->stores),
            "next_stage" => "2" // Just completed stage 1, Now go to Store Information.
        ];
    }

    public function me(Request $request)
    {
        return new UserResource(auth()->user());
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return true;
        }
        return $request->user()->currentAccessToken()->delete();
    }

    public function register(UserCreateRequest $request)
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
            'first_name'     => $request->first_name,
            'last_name' => $request->last_name,
            'email'    => $request->email,
            //'activity_scope' => UserRole::CUSTOMER,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($roles);

        return [
            "token" => $user->createToken('auth_token')->plainTextToken,
            "permissions" => $user->getPermissionNames(),
            "role" => $user->getRoleNames()->first()
        ];
    }

    public function toggleUserStatus(Request $request)
    {
        $userToToggle = User::findOrFail($request->id);
        $user = $request->user();
        if ($user && $user->hasPermissionTo(UserRole::SUPER_ADMIN) && $user->id != $request->id) {
            $userToToggle->is_active = !$userToToggle->is_active;
            $userToToggle->save();

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'status' => $userToToggle->is_active
            ]);
        }

        throw new AuthorizationException(NOT_AUTHORIZED);
    }


    public function banUser(Request $request)
    {
        try {
            $user = $request->user();
            if ($user && $user->hasPermissionTo(UserRole::SUPER_ADMIN) && $user->id != $request->id) {
                $banUser =  User::find($request->id);
                $banUser->is_active = false;
                $banUser->save();
                return $banUser;
            }
            throw new AuthorizationException(NOT_AUTHORIZED);
        } catch (Exception $th) {
            throw new AuthorizationException(SOMETHING_WENT_WRONG);
        }
    }

    public function activeUser(Request $request)
    {
        try {
            $user = $request->user();
            if ($user && $user->hasPermissionTo(UserRole::SUPER_ADMIN) && $user->id != $request->id) {
                $activeUser =  User::find($request->id);
                $activeUser->is_active = true;
                $activeUser->save();
                return $activeUser;
            }
            throw new AuthorizationException(NOT_AUTHORIZED);
        } catch (Exception $th) {
            throw new AuthorizationException(SOMETHING_WENT_WRONG);
        }
    }

    public function forgetPassword(Request $request)
    {
        $user = $this->repository->findByField('email', $request->email);
        if (count($user) < 1) {
            return ['message' => NOT_FOUND, 'success' => false];
        }
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)->first();
        if (!$tokenData) {
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => Str::random(16),
                'created_at' => Carbon::now()
            ]);
            $tokenData = DB::table('password_reset_tokens')
                ->where('email', $request->email)->first();
        }

        if ($this->repository->sendResetEmail($request->email, $tokenData->token)) {
            return ['message' => CHECK_INBOX_FOR_PASSWORD_RESET_EMAIL, 'success' => true];
        } else {
            return ['message' => SOMETHING_WENT_WRONG, 'success' => false];
        }
    }

    public function verifyForgetPasswordToken(Request $request)
    {
        $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$tokenData) {
            return ['message' => INVALID_TOKEN, 'success' => false];
        }
        $user = $this->repository->findByField('email', $request->email);
        if (count($user) < 1) {
            return ['message' => NOT_FOUND, 'success' => false];
        }
        return ['message' => TOKEN_IS_VALID, 'success' => true];
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
                'email' => 'email|required',
                'token' => 'required|string'
            ]);

            $user = $this->repository->where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            return ['message' => PASSWORD_RESET_SUCCESSFUL, 'success' => true];
        } catch (\Exception $th) {
            return ['message' => SOMETHING_WENT_WRONG, 'success' => false];
        }
    }

    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        if (isset($request->roles)) {
            $user->syncRoles($request->roles);
        }
        return redirect()->route('users')->with('success', 'Role assign successfully!');
    }

    public function assignPermissions(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        if (isset($request->permissions)) {
            $user->syncPermissions($request->permissions);
        }
        return response()->json([
            'success' => true,
            'message' => 'Permission assign successfully!',
        ]);
    }
}
