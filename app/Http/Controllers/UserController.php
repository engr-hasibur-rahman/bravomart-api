<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Enums\Role as UserRole;
use App\Helpers\ComHelper;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserDetailsResource;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as ModelsRole;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\GoogleProvider;


class UserController extends Controller
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /* Social login start */
    public function redirectToGoogle()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider */
        $driver = Socialite::driver('google');

        return $driver->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {

        // Retrieve the user information from Google & need to use GoogleProvider for stateless function as laravel socialiate is not compatible with api.
        /** @var \Laravel\Socialite\Two\GoogleProvider */
        $user = Socialite::driver('google');
        $user->stateless()->user();
        $google_id = $user->user()->id;
        $google_email = $user->user()->email;
        $name = $user->user()->name;
        // Find or create a user in the database
        $existingUser = User::where('google_id', $google_id)
            ->orWhere('email', $google_email)->first();

        if ($existingUser) {
            // Update the user's Google ID if it's missing
            if (!$existingUser->google_id) {
                $existingUser->update(['google_id' => $google_id]);
            }

            // Generate a Sanctum token for the existing user
            $token = $existingUser->createToken('api_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => __('auth.social.login'),
                'token' => $token,
                'user' => $existingUser,
            ], 200);
        } else {
            // Create a new user in the database
            $newUser = User::create([
                'first_name' => $name,
                'email' => $google_email,
                'slug' => username_slug_generator($name),
                'google_id' => $google_id,
                'password' => Hash::make('123456dummy'),
            ]);

            // Generate a Sanctum token for the new user
            $token = $newUser->createToken('api_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => __('auth.social.login'),
                'token' => $token,
                'user' => $newUser,
            ], 201);
        }
    }

    /* Social login end */
    public function token(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Attempt to find the user
            $user = User::where('email', $request->email)
                // ->where('activity_scope', 'system_level') // Uncomment if needed
                ->where('status', 1)
                ->first();

            // Check if the user exists and if the password is correct
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    "status" => false,
                    "message" => __('messages.login_failed', ['name' => 'User']),
                    "token" => null,
                    "permissions" => [],
                ], 401);
            }

            // Check if the user's email is verified
            $email_verified = $user->hasVerifiedEmail();

            // Fetch permissions
            $permissions = $user->rolePermissionsQuery()
                ->whereNull('parent_id')
                ->with('childrenRecursive')
                ->get();

            // Build and return the response
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.login_success', ['name' => 'User']),
                "token" => $user->createToken('auth_token')->plainTextToken,
                "permissions" => ComHelper::buildMenuTree($user->roles()->pluck('id')->toArray(), $permissions),
                "email_verified" => $email_verified,
                "role" => $user->getRoleNames()->first(),
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation error response
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => __('messages.validation_failed', ['name' => 'User']),
                "errors" => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Handle other exceptions
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => __('messages.error'),
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function StoreOwnerRegistration($request)
    {
        try {
            // By default role ---->
            $roles = Role::where('available_for', 'store_level')->pluck('name');

            // When admin creates a seller ---->
            if (isset($request->roles)) {
                $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
            }

            // Create the user
            $user = $this->repository->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'slug' => username_slug_generator($request->first_name, $request->last_name),
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'activity_scope' => 'SHOP_AREA',
                'store_owner' => 1,
                'status' => 1,
            ]);

            // Assign roles to the user
            $user->assignRole($roles);

            // Create Merchant ID for the user
            $merchant = ComMerchant::create(['user_id' => $user->id]);

            // Save Merchant ID in Users table
            $user->merchant_id = $merchant->id;
            $user->save();

            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.registration_success', ['name' => 'Seller']),
                "token" => $user->createToken('auth_token')->plainTextToken,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                "permissions" => $user->getPermissionNames(),
                "role" => $user->getRoleNames(),
                "store_owner" => $user->store_owner,
                "merchant_id" => $user->merchant_id,
                "stores" => json_decode($user->stores),
                "next_stage" => "2"
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => __('messages.validation_failed', ['name' => 'Seller']),
                "errors" => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Handle unexpected errors
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => __('messages.error'),
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function me(Request $request)
    {
        return new UserResource(auth()->guard('api')->user());
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return true;
        }
        $request->user()->currentAccessToken()->delete();
        return $this->success(__('auth.logout'));
    }

    public function register(UserCreateRequest $request)
    {
        try {
            // Prevent unauthorized role assignment
            $notAllowedRoles = [UserRole::SUPER_ADMIN];

            if ((isset($request->roles->value) && in_array($request->roles->value, $notAllowedRoles)) ||
                (isset($request->roles) && in_array($request->roles, $notAllowedRoles))
            ) {
                throw new AuthorizationException(NOT_AUTHORIZED);
            }

            // Fetch roles available for customer-level
            $roles = Role::where('available_for', 'customer_level')->pluck('name');

            if (isset($request->roles)) {
                $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
            }

            // Create the user
            $user = $this->repository->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'slug' => username_slug_generator($request->first_name, $request->last_name),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 1
            ]);

            // Assign roles to the user
            $user->assignRole($roles);

            // Return a successful response with the token and permissions
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.registration_success', ['name' => 'Customer']),
                "token" => $user->createToken('auth_token')->plainTextToken,
                "permissions" => $user->getPermissionNames(),
                "role" => $user->getRoleNames()->first()
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => __('messages.validation_failed', ['name' => 'Customer']),
                "errors" => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Handle unexpected errors
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => __('messages.error'),
                "error" => $e->getMessage(),

            ], 500);
        }
    }

    public function toggleUserStatus(Request $request)
    {
        $userToToggle = User::findOrFail($request->id);
        $user = $request->user();
        if ($user && $user->hasPermissionTo(UserRole::SUPER_ADMIN) && $user->id != $request->id) {
            $userToToggle->status = !$userToToggle->status;
            $userToToggle->save();

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'status' => $userToToggle->status
            ]);
        }
        throw new AuthorizationException(NOT_AUTHORIZED);
    }

    public function banUser(Request $request)
    {
        try {
            $user = $request->user();
            if ($user && $user->hasPermissionTo(UserRole::SUPER_ADMIN) && $user->id != $request->id) {
                $banUser = User::find($request->id);
                $banUser->status = 0;
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
                $activeUser = User::find($request->id);
                $activeUser->status = 1;
                $activeUser->save();
                return $activeUser;
            }
            throw new AuthorizationException(NOT_AUTHORIZED);
        } catch (Exception $th) {
            throw new AuthorizationException(SOMETHING_WENT_WRONG);
        }
    }

    /* <---- Forget password proccess start ----> */
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
            return ['message' => __('passwords.sent'), 'success' => true];
        } else {
            return ['message' => __('passwords.error'), 'success' => false];
        }
        // if ($this->repository->sendResetEmail($request->email, $tokenData->token)) {
        //     return ['message' => CHECK_INBOX_FOR_PASSWORD_RESET_EMAIL, 'success' => true];
        // } else {
        //     return ['message' => SOMETHING_WENT_WRONG, 'success' => false];
        // }
    }

    public function verifyForgetPasswordToken(Request $request)
    {
        $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$tokenData) {
            return ['message' => __('passwords.token.invalid'), 'success' => false];
            // return ['message' => INVALID_TOKEN, 'success' => false];
        }
        $user = $this->repository->findByField('email', $request->email);
        if (count($user) < 1) {
            return ['message' => __('passwords.user'), 'success' => false];
            // return ['message' => NOT_FOUND, 'success' => false];
        }
        return ['message' => __('passwords.token.valid'), 'success' => true];
        // return ['message' => TOKEN_IS_VALID, 'success' => true];
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
                'confirm_password' => 'required|string|same:password',
                'email' => 'email|required',
                'token' => 'required|string'
            ]);
            $user = $this->repository->where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            return ['message' => __('passwords.reset'), 'success' => true];
            // return ['message' => PASSWORD_RESET_SUCCESSFUL, 'success' => true];
        } catch (Exception $th) {
            return ['message' => __('passwords.error'), 'success' => false];
            // return ['message' => SOMETHING_WENT_WRONG, 'success' => false];
        }
    }
    /* <---- Forget password proccess end ----> */
    /* <---- Assign roles & permissions proccess start ----> */
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
    /* <---- Assign roles & permissions process end ----> */
    /* <---- User profile start ----> */
    public function userProfile()
    {
        try {
            if (!auth()->guard('api')->user()) {
                return unauthorized_response();
            }

            $userId = auth('api')->id();
            $user = User::findOrFail($userId);

            return new UserDetailsResource($user);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => __('messages.data_not_found'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.something_went_wrong'),
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function userProfileUpdate(UserUpdateRequest $request)
    {
        try {
            if (!auth()->guard('api')->user()) {
                return unauthorized_response();
            }

            $userId = auth('api')->id();
            $user = User::findOrFail($userId);

            if ($user) {
                $user->update($request->only('first_name', 'last_name', 'phone', 'image'));
                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.update_success', ['name' => 'User']),
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'status_code' => 500,
                    'message' => __('messages.update_failed'),
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => __('messages.data_not_found'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.something_went_wrong'),
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function userEmailUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            if (!auth()->guard('api')->user()) {
                return unauthorized_response();
            }
            $userId = auth('api')->id();
            $user = User::findOrFail($userId);
            if ($user) {
                $user->update($request->only('email'));
                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.update_success', ['name' => 'User']),
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'status_code' => 500,
                    'message' => __('messages.update_failed'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.something_went_wrong'),
                'error' => $e->getMessage(),
            ]);
        }
    }
    /* <---- User profile end ----> */
}
