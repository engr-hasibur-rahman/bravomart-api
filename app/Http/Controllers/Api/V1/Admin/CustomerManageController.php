<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Customer\CustomerDetailsResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

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
}
