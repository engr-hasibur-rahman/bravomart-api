<?php

namespace App\Http\Controllers\Api\V1\Deliveryman;

use App\Http\Controllers\Controller;
use App\Interfaces\DeliverymanManageInterface;
use App\Models\DeliveryMan;
use App\Models\OrderActivity;
use App\Models\OrderDeliveryHistory;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class DeliverymanManageController extends Controller
{
    public function __construct(protected DeliverymanManageInterface $deliverymanRepo)
    {

    }

    public function registration(Request $request)
    {

        try {
            // By default role ---->
            $roles = Role::where('available_for', 'delivery_level')->pluck('name');

            // When admin creates a Deliveryman ---->
            if (isset($request->roles)) {
                $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
            }

            // Create the user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'slug' => username_slug_generator($request->first_name, $request->last_name),
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'activity_scope' => 'delivery_level',
                'store_owner' => 0,
                'status' => 1,
            ]);
            $user_details = Deliveryman::create([
                'user_id' => $user->id,
                'status' => 'approved',
            ]);

            // Assign roles to the user
            $user->assignRole($roles);
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.registration_success', ['name' => 'Deliveryman']),
                "token" => $user->createToken('auth_token')->plainTextToken,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                "permissions" => $user->getPermissionNames(),
                "role" => $user->getRoleNames(),
                "next_stage" => "2"
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "message" => __('messages.validation_failed', ['name' => 'Deliveryman']),
                "errors" => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                "message" => __('messages.error'),
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Attempt to find the user
            $user = User::where('email', $request->email)
                ->where('activity_scope', 'delivery_level') // Uncomment if needed
                ->where('status', 1)
                ->where('deleted_at', null)
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
                "message" => __('messages.login_success', ['name' => 'Deliveryman']),
                "token" => $user->createToken('auth_token')->plainTextToken,
                "deliveryman_id" => $user->id,
                "email_verified" => $email_verified,
                "activity_notification" => (bool)$user->activity_notification,
                "account_status" => $user->deactivated_at ? 'deactivated' : 'active',
                "role" => $user->getRoleNames()->first(),
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation error response
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => __('messages.validation_failed', ['name' => 'Deliveryman']),
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

    public function activeDeactiveAccount(Request $request)
    {
        if (!auth('api')->check()) {
            unauthorized_response();
        }
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:activate,deactivate',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deliveryman = auth('api')->user();
        $existing_orders = OrderDeliveryHistory::where('deliveryman_id',$deliveryman->id);
        if ($request->type == 'deactivate') {
            $alreadyDeactivated = $deliveryman->deactivated_at;
            if ($alreadyDeactivated) {
                return response()->json([
                    'message' => __('messages.account_already_deactivated')
                ], 422);
            }

            $deliveryman->update([
                'deactivated_at' => now(),
                'status' => 0,
            ]);

            return response()->json([
                'message' => __('messages.account_deactivate_successful')
            ], 200);
        }

        if ($request->type == 'activate') {
            $alreadyActivated = $deliveryman->deactivated_at == null;
            if ($alreadyActivated) {
                return response()->json([
                    'message' => __('messages.account_already_activated')
                ], 422);
            }
            $activate = $deliveryman->update([
                'deactivated_at' => null,
            ]);
            if ($activate) {
                return response()->json([
                    'message' => __('messages.account_activate_successful')
                ], 200);
            } else {
                return response()->json([
                    'message' => __('messages.account_activate_failed')
                ], 500);
            }
        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong')
            ], 500);
        }
    }

    public function activityNotificationToggle()
    {
        $deliveryman = auth('api')->user();
        $deliveryman->activity_notification = !$deliveryman->activity_notification;
        $deliveryman->save();

        return response()->json([
            'message' => __('messages.account_activity_notification_update_success'),
            'status' => $deliveryman->activity_notification
        ], 200);
    }
}
