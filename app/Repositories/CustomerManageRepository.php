<?php

namespace App\Repositories;

use App\Http\Resources\Customer\CustomerDashboardResource;
use App\Interfaces\CustomerManageInterface;
use App\Mail\EmailVerificationMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Wishlist;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CustomerManageRepository implements CustomerManageInterface
{
    protected $customer_id;

    public function __construct(protected Customer $customer)
    {
        $this->customer_id = auth('api_customer')->user()->id;
    }

    public function register(array $data)
    {
        try {
            return $this->customer->create($data);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => __('messages.error'),
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    /* ------------------------------------------------------ Reset and Verification --------------------------------------------------------------- */
    // Send email verification link
    public function sendVerificationEmail(string $email)
    {
        $customer = $this->customer->where('email', $email)->first();

        if (!$customer) {
            return false;
        }

        try {
            $token = Str::random(10);
            $customer->email_verify_token = $token;
            $customer->save();
            // Send email verification
            Mail::to($customer->email)->send(new EmailVerificationMail($customer));

            return true;
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }

    // Verify email with the provided token
    public function verifyEmail(string $token)
    {
        $customer = $this->customer->where('email_verify_token', $token)->first();

        if (!$customer) {
            return false;
        }

        try {
            $customer->email_verified = 1;
            $customer->email_verified_at = now();
            $customer->email_verify_token = null;
            $customer->save();

            return true;
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }

    // Resend the verification email
    public function resendVerificationEmail(string $email)
    {
        return $this->sendVerificationEmail($email);
    }

    /* ------------------------------------------------------- Password Reset and forget password --------------------------------------------------------------------- */
    public function forgetPassword(string $email)
    {
        return $this->sendVerificationEmail($email);
    }

    public function verifyToken(string $token)
    {
        $customer = $this->customer->where('email_verify_token', $token)->first();

        if (!$customer) {
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

    public function resetPassword(array $data)
    {
        $customer = $this->customer
            ->where('email', $data['email'])
            ->where('email_verify_token', $data['token'])
            ->first();

        if (!$customer) {
            return false;
        }

        try {
            $customer->password = Hash::make($data['password']);
            $customer->password_changed_at = now();
            $customer->email_verify_token = null;
            $customer->save();

            return true;
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function deactivateAccount()
    {
        $user = auth('api_customer')->user();
        $user->update([
            'status' => 0,
            'deactivated_at' => now(),
        ]);
        $user->currentAccessToken()->delete();
        return true;
    }

    public function deleteAccount()
    {
        $user = auth('api_customer')->user();
        $user->delete(); // Soft delete
        $user->currentAccessToken()->delete();
        return true;
    }

    public function getDashboard()
    {
        return [
            'wishlist_count' => $this->getWishlistCount(),
            'total_orders' => $this->getTotalOrders(),
            'pending_orders' => $this->getPendingOrders(),
            'canceled_orders' => $this->getCanceledOrders(),
            'on_hold_products' => $this->getOnHoldProducts(),
            'recent_orders' => $this->getRecentOrders(),
        ];
    }

    protected function getWishlistCount()
    {
        return Wishlist::where('customer_id', $this->customer_id)->count();
    }

    protected function getTotalOrders()
    {
        return Order::where('customer_id', $this->customer_id)->count();
    }

    protected function getPendingOrders()
    {
        return Order::where('customer_id', $this->customer_id)
            ->where('status', 'pending')
            ->count();
    }

    protected function getCanceledOrders()
    {
        return Order::where('customer_id', $this->customer_id)
            ->where('status', 'cancelled')
            ->count();
    }

    protected function getOnHoldProducts()
    {
        return Order::where('customer_id', $this->customer_id)
            ->where('status', 'on_hold')
            ->count();
    }

    protected function getRecentOrders()
    {
        return Order::where('customer_id', $this->customer_id)
            ->where('status', 'delivered')
            ->latest()
            ->limit(5)
            ->get();
    }

}
