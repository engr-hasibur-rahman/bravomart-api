<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\Customer\CustomerDashboardResource;
use App\Http\Resources\Customer\CustomerProfileResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Interfaces\CustomerManageInterface;
use App\Mail\EmailVerificationMail;
use App\Models\Customer;
use App\Models\CustomerDeactivationReason;
use App\Models\UniversalNotification;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CustomerManageController extends Controller
{
    public function __construct(protected CustomerManageInterface $customerRepo)
    {
    }

    public function register(CustomerRequest $request)
    {
        try {
            $customer = Customer::create($request->all());
            $token = $customer->createToken('customer_auth_token')->plainTextToken;
            // Return a successful response with the token and permissions
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.registration_success', ['name' => 'Customer']),
                "token" => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors()
            ],422);
        }

        $customer = Customer::where('email', $request->email)
            ->first();
        if (!$customer) {
            return response()->json([
                "status" => false,
                "message" => __('messages.customer.not.found'),
            ],204);
        }

        // update firebase device token
        $customer->update([
            'firebase_token' => $request->firebase_device_token,
        ]);

        // Check if the user's account is deleted
        if ($customer->deleted_at !== null) {
            return response()->json([
                'error' => 'Your account has been deleted. Please contact support.'
            ], Response::HTTP_GONE); // HTTP 410 Gone
        }
        // Check if the user's account is deactivated or disabled
        if ($customer->status === 0) {
            return response()->json([
                'error' => 'Your account has been deactivated. Please contact support.'
            ], Response::HTTP_FORBIDDEN); // HTTP 403 Forbidden
        }
        if ($customer->status === 2) {
            return response()->json([
                'error' => 'Your account has been suspended by the admin.'
            ], Response::HTTP_FORBIDDEN); // HTTP 403 Forbidden
        }
        $authCustomer = Hash::check($request->password, $customer->password);
        // Check if the user exists and if the password is correct
        if (!$authCustomer) {
            return response()->json([
                "status" => false,
                "message" => __('messages.wrong_credential'),
                "token" => null,
            ],204);
        } else {
            // Handle the "Remember Me" option
            $remember_me = $request->has('remember_me');

            // Set token expiration dynamically
            config(['sanctum.expiration' => $remember_me ? null : env('SANCTUM_EXPIRATION')]);
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.login_success', ['name' => 'Customer']),
                "token" => $customer->createToken('customer_auth_token')->plainTextToken,
                "email_verified" => (bool)$customer->email_verified, // shorthand of -> $token->email_verified ? true : false
                "account_status" => $customer->deactivated_at ? 'deactivated' : 'active',
                "marketing_email" => (bool)$customer->marketing_email,
                "activity_notification" => (bool)$customer->activity_notification,
            ]);
        }
    }
    /* ---------------------------------------------------------- Reset and Verification -------------------------------------------------------- */

    // Verify email with token
    public function verifyEmail(Request $request)
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

        $result = $this->customerRepo->verifyEmail($request->token);

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
            'message' => __('messages.email.verify.success')
        ]);
    }

    // Resend verification email
    public function resendVerificationEmail(Request $request)
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
            $result = $this->customerRepo->resendVerificationEmail($request->email);

            if (!$result) {
                return response()->json([
                    'status' => false,
                    'status_code' => 500,
                    'message' => __('messages.email.resend.failed')
                ], 500);
            }

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.email.resend.success')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

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
            $result = $this->customerRepo->sendVerificationEmail($request->email);

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

        $result = $this->customerRepo->verifyToken($request->token);

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

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $validator->errors()
            ]);
        }
        $result = $this->customerRepo->resetPassword($request->all());

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

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => $validator->errors()
            ], 422);
        }

        $result = $this->customerRepo->changePassword($request->only(['old_password', 'new_password']));

        if ($result === 'incorrect_old_password') {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => 'Incorrect password!'
            ], 400);
        }

        if (!$result) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.password_update_failed')
            ], 500);
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.password_update_successful')
        ]);
    }


    public function getProfile()
    {
        try {
            if (!auth('sanctum')->check()) {
                return unauthorized_response();
            }

            $userId = auth('sanctum')->id();
            $user = Customer::findOrFail($userId);

            // count unread customer notification
            $unreadNotifications = UniversalNotification::forCustomers()
                ->where('notifiable_id', $userId)
                ->where('status', 'unread')
                ->count();

            $wishlist_count = Wishlist::where('customer_id', $userId)->count();

            $user->unread_notifications = $unreadNotifications;
            $user->wishlist_count = $wishlist_count;

            return new CustomerProfileResource($user);
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

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'image' => 'nullable|string',
            'birth_day' => 'nullable|date|date_format:Y-m-d',
            'gender' => 'nullable|string|in:male,female,others',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => $validator->errors()
            ]);
        }
        try {
            if (!auth('sanctum')->check()) {
                return unauthorized_response();
            }

            $userId = auth('sanctum')->id();
            $user = Customer::findOrFail($userId);

            if ($user) {
                $user->update($request->only('first_name', 'last_name', 'phone', 'image', 'birth_day', 'gender'));
                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.update_success', ['name' => 'Customer']),
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'status_code' => 500,
                    'message' => __('messages.update_failed', ['name' => 'Customer']),
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

    public function sendVerificationEmail(Request $request)
    {
        if (!auth('api_customer')->check()) {
            return unauthorized_response();
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $user = auth('api_customer')->user();

        try {
            $token = rand(100000, 999999);
            $user->email_verify_token = $token;
            $user->save();
            // Send email verification
            Mail::to($request->email)->send(new EmailVerificationMail($user));

            return response()->json(['status' => true, 'message' => 'Verification email sent.']);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function updateEmail(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return unauthorized_response();
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,email',
            'token' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        try {

            $userId = auth('api_customer')->id();
            $user = Customer::findOrFail($userId);
            if ($user && $user->email_verify_token == $request->token) {
                $user->update([
                    'email' => $request->email,
                    'email_verify_token' => null,
                ]);
                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => __('messages.update_success', ['name' => 'Customer']),
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'status_code' => 500,
                    'message' => __('messages.update_failed', ['name' => 'Customer']),
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

    public function activeDeactiveAccount(Request $request)
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:activate,deactivate',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $customer = auth('api_customer')->user();
        if ($request->type == 'deactivate') {
            $validator = Validator::make($request->only(['reason', 'description']), [
                'reason' => 'required|string|max:255',
                'description' => 'required|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], 422);
            }
            $alreadyDeactivated = $customer->deactivated_at;
            if ($alreadyDeactivated) {
                return response()->json([
                    'message' => __('messages.account_already_deactivated')
                ], 422);
            }
            $reason = CustomerDeactivationReason::create([
                'customer_id' => $customer->id,
                'reason' => $request->reason,
                'description' => $request->description
            ]);
            if ($reason) {
                $customer->update([
                    'deactivated_at' => now(),
                ]);
            }
            return response()->json([
                'message' => __('messages.account_deactivate_successful')
            ], 200);
        }

        if ($request->type == 'activate') {
            $alreadyActivated = $customer->deactivated_at == null;
            if ($alreadyActivated) {
                return response()->json([
                    'message' => __('messages.account_already_activated')
                ], 422);
            }
            $activate = $this->customerRepo->activateAccount();
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

    public function deleteAccount()
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        $success = $this->customerRepo->deleteAccount();
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

    public function getDashboard()
    {
        // Check if the customer is authenticated
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        $dashboardData = $this->customerRepo->getDashboard();
        // Return the response using the resource
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'data' => new CustomerDashboardResource($dashboardData),
        ]);
    }

    public function activityNotificationToggle()
    {
        $customer = auth('api_customer')->user();
        $customer->activity_notification = !$customer->activity_notification;
        $customer->save();

        return response()->json([
            'message' => __('messages.account_activity_notification_update_success'),
            'status' => $customer->activity_notification
        ], 200);
    }

    public function marketingEmailToggle()
    {
        $customer = auth('api_customer')->user();
        $customer->marketing_email = !$customer->marketing_email;
        $customer->save();

        return response()->json([
            'message' => __('messages.account_marketing_notification_update_success'),
            'status' => $customer->marketing_email
        ]);
    }
}
