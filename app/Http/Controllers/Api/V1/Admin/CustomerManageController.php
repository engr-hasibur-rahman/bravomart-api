<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Customer\CustomerDetailsResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Interfaces\CustomerManageInterface;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerManageController extends Controller
{
    public function __construct(protected CustomerManageInterface $customerManageRepo)
    {

    }

    public function getCustomerList(Request $request)
    {
        $query = Customer::query();

        if (isset($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'LIKE', "%{$request->search}%")
                    ->orWhere('last_name', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%")
                    ->orWhere('phone', 'LIKE', "%{$request->search}%");
            });
        }
        if (isset($request->status)) {
            $query->where("status", $request->status);
        }
        $customers = $query->latest()->paginate($request->perPage ?? 10);
        return response()->json([
            'customers' => CustomerResource::collection($customers),
            'meta' => new PaginationResource($customers)
        ]);
    }

    public function register(CustomerRequest $request)
    {
        try {
            $customer = Customer::create($request->all());
            // Return a successful response with the token and permissions
            if ($customer) {
                return response()->json([
                    "message" => __('messages.registration_success', ['name' => 'Customer']),
                ]);
            } else {
                return response()->json([
                    "message" => __('messages.registration_failed', ['name' => 'Customer']),
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getCustomerDetails(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        return response()->json(new CustomerDetailsResource($customer));
    }

    public function changeStatus(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->status = $request->status;
        $customer->save();

        return $this->success(translate('messages.update_success', ['name' => 'Customer']));
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $customer = $this->change_password($request->customer_id, $request->password);
        if ($customer) {
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Customer password']),
            ]);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], 404);
        }
    }

    private function change_password(int $customer_id, string $password)
    {
        if (auth('api')->check()) {
            unauthorized_response();
        }
        $customer = Customer::where('id', $customer_id)->first();
        if (!$customer) {
            return false;
        }
        $customer->password = Hash::make($password);
        $customer->save();
        return $customer;
    }

    public function emailVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $customer = Customer::find($request->customer_id);
        if (!$customer) {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], 404);
        }
        $customer->email_verified = 1;
        $customer->email_verified_at = now();
        $customer->save();
        return response()->json([
            'message' => __('messages.email.verify.success'),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
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

            $userId = $request->customer_id;
            $user = Customer::findOrFail($userId);

            if ($user) {
                $user->update($request->only('first_name', 'last_name', 'email', 'phone', 'image', 'birth_day', 'gender'));
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

    public function suspend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $customer = Customer::find($request->customer_id);
        if (!$customer) {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], 404);
        }
        $customer->status = 2;
        $customer->save();
        return response()->json([
            'message' => __('messages.suspended', ['name' => 'Customer']),
        ]);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_ids'   => 'required|array',
            'customer_ids.*' => 'required|exists:customers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $deleted = 0;
        $skipped = [];
        $failed = [];

        foreach ($request->customer_ids as $customerId) {
            $customer = Customer::find($customerId);

            if (!$customer) {
                $failed[] = $customerId;
                continue;
            }

            if ($customer->hasRunningOrders()) {
                $skipped[] = $customerId;
                continue;
            }

            $success = $this->customerManageRepo->deleteCustomerRelatedAllData($customerId);

            if ($success) {
                $deleted++;
            } else {
                $failed[] = $customerId;
            }
        }

        return response()->json([
            'message' => "Processed: $deleted deleted, " . count($skipped) . " skipped (running orders), " . count($failed) . " failed.",
            'deleted' => $deleted,
            'skipped' => $skipped,
            'failed'  => $failed,
        ]);
    }
}
