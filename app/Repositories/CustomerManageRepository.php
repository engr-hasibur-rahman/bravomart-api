<?php

namespace App\Repositories;

use App\Interfaces\CustomerManageInterface;
use App\Mail\EmailVerificationMail;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CustomerManageRepository implements CustomerManageInterface
{
    public function __construct(protected Customer $customer)
    {

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

    public function getToken(array $data)
    {
        try {
            // Attempt to find the user
            $customer = $this->customer->where('email', $data['email'])
                ->where('status', 1)
                ->first();
            if (!$customer) {
                return response()->json([
                    "status" => false,
                    "status_code" => 404,
                    "message" => __('messages.customer.not.found'),
                ], 404);
            }
            $authCustomer = Hash::check($data['password'], $customer->password);
            // Check if the user exists and if the password is correct
            if (!$authCustomer) {
                return response()->json([
                    "status" => false,
                    "status_code" => 401,
                    "message" => __('messages.login_failed', ['name' => 'Customer']),
                    "token" => null,
                ], 401);
            }
            // Build and return the response
            return $customer;
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => $e->getMessage()
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
}
