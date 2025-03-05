<?php

namespace App\Http\Controllers;

use App\Actions\ImageModifier;
use App\Enums\Role as UserRole;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Resources\UserResource;
use App\Mail\EmailVerificationMail;
use App\Models\StoreSeller;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;


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
                ->where('activity_scope', 'system_level') // Uncomment if needed
                ->where('status', 1)
                ->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'status_code' => 422,
                    'message' => 'User is not an admin!'
                ]);
            }

            // Check if the user exists and if the password is correct
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    "status" => false,
                    "message" => __('messages.login_failed', ['name' => 'Admin']),
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
                "message" => __('messages.login_success', ['name' => 'Admin']),
                "token" => $user->createToken('auth_token')->plainTextToken,
//                "permissions" => ComHelper::buildMenuTree($user->roles()->pluck('id')->toArray(), $permissions),
                "email_verified" => $email_verified,
                "role" => $user->getRoleNames()->first(),
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation error response
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => __('messages.validation_failed', ['name' => 'Admin']),
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

    public function StoreOwnerRegistration(Request $request)
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
                'activity_scope' => 'store_level',
                'store_owner' => 1,
                'status' => 1,
            ]);

            // Assign roles to the user
            $user->assignRole($roles);

            // Create seller ID for the user
            $seller = StoreSeller::create(['user_id' => $user->id]);

            // Save seller ID in Users table
            $user->store_seller_id = $seller->id;
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
                "store_seller_id" => $user->store_seller_id,
                "stores" => json_decode($user->stores),
                "next_stage" => "2"
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "message" => __('messages.validation_failed', ['name' => 'Seller']),
                "errors" => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $validator->errors()
            ]);
        }
        try {
            $result = $this->sendVerificationEmail($request->email);

            if (!$result) {
                return response()->json([
                    'status' => false,
                    'status_code' => 500,
                    'message' => __('messages.data_not_found')
                ], 404);
            }
            return response()->json(['status' => true, 'message' => 'Verification email sent.']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function sendVerificationEmail(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        try {
            $token = rand(100000, 999999);
            $user->email_verify_token = $token;
            $user->save();
            // Send email verification
            Mail::to($user->email)->send(new EmailVerificationMail($user));

            return true;
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function verifyToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $validator->errors()
            ]);
        }

        $result = $this->verify_token($request->token);

        if (!$result) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.token.invalid')
            ], 400);
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.token.verified')
        ]);
    }

    private function verify_token(string $token)
    {
        $user = User::where('email_verify_token', $token)->first();

        if (!$user) {
            return false;
        }

        try {
            return true;
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:15|confirmed',
            'token' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $validator->errors()
            ]);
        }
        $result = $this->reset_password($request->all());

        if (!$result) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.token.invalid')
            ], 400);
        }
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.password_update_successful')
        ]);
    }
    private function reset_password(array $data)
    {
        $user = User::where('email', $data['email'])
            ->where('email_verify_token', $data['token'])
            ->first();

        if (!$user) {
            return false;
        }

        try {
            $user->password = Hash::make($data['password']);
            $user->password_changed_at = now();
            $user->email_verify_token = null;
            $user->save();

            return true;
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
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
            'message' => 'PermissionKey assign successfully!',
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

            return response()->json(new UserDetailsResource($user));
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

    public function deactivateAccount()
    {
        if (!auth('api')->check()) {
            unauthorized_response();
        }
        $user = auth('api')->user();
        $user->update([
            'status' => 0,
            'deactivated_at' => now(),
        ]);
        $success = $user->currentAccessToken()->delete();
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.account_deactivate_successful')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.account_deactivate_failed')
            ]);
        }

    }

    public function deleteAccount()
    {
        if (!auth('api')->check()) {
            unauthorized_response();
        }
        $user = auth('api')->user();
        $user->delete(); // Soft delete
        $success = $user->currentAccessToken()->delete();
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.account_delete_successful')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.account_delete_failed')
            ]);
        }
    }
    /* <---- User profile end ----> */
}
