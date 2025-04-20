<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Customer\CustomerDetailsResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerManageController extends Controller
{
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
        $customers = $query->paginate($request->perPage ?? 10);
        return response()->json([
            'customers' => CustomerResource::collection($customers),
            'meta' => new PaginationResource($customers)
        ]);
    }

    public function getCustomerDetails(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        return response()->json(new CustomerDetailsResource($customer));
    }

    public function changeStatus(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->status = !$customer->status;
        $customer->save();

        return $this->success(translate('messages.update_success', ['name' => 'Customer']));
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'password' => 'required|min:8|max:12',
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
            ],404);
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
}
