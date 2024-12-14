<?php

namespace App\Repositories;

use App\Http\Resources\Customer\AddressResource;
use App\Interfaces\AddressManageInterface;
use App\Models\CustomerAddress;

class AddressManageRepository implements AddressManageInterface
{
    public function __construct(protected CustomerAddress $address)
    {
    }

    /**
     * @param CustomerAddress $address
     */
    public function setAddress(array $data)
    {
        try {
            if (isset($data['is_default']) && $data['is_default']) {
                $this->address
                    ->where('customer_id', $data['customer_id'])
                    ->where('is_default', 1)
                    ->update(['is_default' => 0]);
            }
            $this->address->create($data);
            return true;
        } catch (\Exception $e) {
            // Return the error message
            return $e->getMessage();
        }
    }

    public function getAddress(?int $id, ?string $type, int $status)
    {
        try {
            $customerId = auth('api')->id();

            // Build query to get addresses
            $query = $this->address->where('customer_id', $customerId);

            // Apply filters only if they are provided and not empty
            if (isset($id)) {
                $query->where('status', $id);
            }
            if (!empty($type)) {
                $query->where('type', $type);
            }
            if (isset($status)) {
                $query->where('status', $status);
            }
            $addresses = $query->get();
            return $addresses;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function handleDefaultAddress(array $data)
    {
        try {
            if (isset($data['is_default']) && $data['is_default']) {
                $this->address
                    ->where('customer_id', $data['customer_id'])
                    ->where('is_default', 1)
                    ->update(['is_default' => 0]);
            }
            $this->address->where('id', $data['id'])->update(['is_default' => $data['is_default']]);
            return true;
        } catch (\Exception $e) {
            // Return the error message
            return $e->getMessage();
        }
    }
}