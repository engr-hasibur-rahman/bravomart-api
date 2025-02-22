<?php

namespace App\Repositories;

use App\Enums\WalletOwnerType;
use App\Interfaces\DeliverymanManageInterface;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\OrderDeliveryHistory;
use App\Models\SystemCommission;
use App\Models\Translation;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Modules\Wallet\app\Models\Wallet;
use Modules\Wallet\app\Models\WalletTransaction;

class DeliverymanManageRepository implements DeliverymanManageInterface
{

    public function __construct(protected VehicleType $vehicleType, protected Translation $translation)
    {
    }

    public function translationKeys(): mixed
    {
        return $this->vehicleType->translationKeys;
    }

    /*------------------------------------------------------------>DeliveryMan Start<---------------------------------------------------*/
    public function getAllDeliveryman(array $filters)
    {
        $query = DeliveryMan::with([
            'user',
            'vehicle_type',
            'area',
            'creator',
            'updater'
        ]);
        if (isset($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
            });
        }

        if (isset($filters['vehicle_type_id'])) {
            $query->where('vehicle_type_id', $filters['vehicle_type_id']);
        }

        if (isset($filters['area_id'])) {
            $query->where('area_id', $filters['area_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['identification_type'])) {
            $query->where('identification_type', 'like', '%' . $filters['identification_type'] . '%');
        }

        if (isset($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }
        $deliverymen = $query->paginate($filters['per_page'] ?? 10);

        return $deliverymen;
    }

    public function store(array $data)
    {
        DB::beginTransaction();


        // Create the deliveryman user record
        $deliveryman = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'slug' => username_slug_generator($data['first_name'], $data['last_name']),
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'],
            'activity_scope' => 'delivery_level',
            'password' => $data['password'],
            'store_owner' => 0,
            'store_seller_id' => null,
            'stores' => null,
            'status' => $data['status'] ?? 0,
        ]);

        if (!$deliveryman) {
            DB::rollBack();
            return null;
        }
        $deliverymanExtra = DeliveryMan::create([
            'user_id' => $deliveryman->id,
            'store_id' => $data['store_id'] ?? null,
            'vehicle_type_id' => $data['vehicle_type_id'] ?? null,
            'area_id' => $data['area_id'] ?? null,
            'identification_type' => $data['identification_type'],
            'identification_number' => $data['identification_number'],
            'identification_photo_front' => $data['identification_photo_front'] ?? null,
            'identification_photo_back' => $data['identification_photo_back'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => 'approved',
            'created_by' => auth('api')->user()->id,
        ]);


        if (!$deliverymanExtra) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return $deliveryman->id;

    }

    public function update(array $data)
    {
        DB::beginTransaction();
        // Find the existing user record
        $user = User::find($data['user_id']);
        if (!$user) {
            DB::rollBack();
            return null;  // Return null if user does not exist
        }

        // Update the deliveryman user record
        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'slug' => username_slug_generator($data['first_name'], $data['last_name']),
            'phone' => $data['phone'] ?? null,
            'activity_scope' => 'delivery_level',
            'store_owner' => 0,
            'store_seller_id' => null,
            'stores' => null,
            'status' => $data['status'] ?? 0,
        ]);

        // Find and update the associated DeliveryMan record
        $deliveryman = DeliveryMan::where('user_id', $data['user_id'])->first();

        if (!$deliveryman) {
            DB::rollBack();
            return null;  // Return null if DeliveryMan does not exist
        }

        // Update the DeliveryMan extra details
        $deliveryman->update([
            'vehicle_type_id' => $data['vehicle_type_id'] ?? null,
            'store_id' => $data['store_id'] ?? null,
            'area_id' => $data['area_id'] ?? null,
            'identification_photo_front' => $data['identification_photo_front'] ?? null,
            'identification_photo_back' => $data['identification_photo_back'] ?? null,
            'address' => $data['address'] ?? null,
            'updated_by' => auth('api')->user()->id,
        ]);
        DB::commit();  // Commit transaction if all updates succeed
        return $user->id;  // Return user ID on success

    }

    public function getDeliverymanById(int $id)
    {
        $deliveryman = DeliveryMan::with('user', 'vehicle_type', 'area', 'creator', 'updater')
            ->find($id);
        if (!$deliveryman) {
            return false;
        }
        return $deliveryman;
    }

    public function delete(int $userId)
    {
        DB::beginTransaction();
        $user = User::find($userId);
        if (!$user) {
            DB::rollBack();
            return false;
        }
        $deliveryman = DeliveryMan::where('user_id', $userId)->first();
        if ($deliveryman) {
            $deliveryman->delete();
        }
        $user->delete();

        DB::commit();
        return true;

    }

    public function getDeliverymanRequests()
    {
        try {
            $deliverymen = DeliveryMan::with([
                'user',
                'vehicle_type',
                'area',
                'creator',
                'updater'
            ])
                ->where('deleted_at', null)
                ->pendingDeliveryman()
                ->paginate(10);
            return $deliverymen;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function approveDeliverymen(array $deliveryman_ids)
    {
        try {
            $deliverymen = User::whereIn('id', $deliveryman_ids)
                ->where('status', 0)
                ->where('activity_scope', 'delivery_level')
                ->where('deleted_at', null)
                ->update(['status' => 1]);
            return $deliverymen > 0;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function changeStatus(array $data)
    {
        try {
            $deliverymen = User::whereIn('id', $data['deliveryman_ids'])
                ->where('deleted_at', null)
                ->where('activity_scope', 'delivery_level')
                ->update(['status' => $data['status']]);
            return $deliverymen > 0;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /*------------------------------------------------------------>Vehicle Type Start<---------------------------------------------------*/
    public function getAllVehicles(array $filters)
    {
        $query = VehicleType::query();

        if (isset($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm)
                    ->orWhereHas('related_translations', function ($q) use ($searchTerm) {
                        $q->whereIn('key', ['name', 'description'])
                            ->where('value', 'LIKE', $searchTerm);
                    });
            });
        }
        // Filter by capacity (e.g., minimum and maximum capacity)
        if (isset($filters['min_capacity'])) {
            $query->where('capacity', '>=', $filters['min_capacity']);
        }
        if (isset($filters['max_capacity'])) {
            $query->where('capacity', '<=', $filters['max_capacity']);
        }

        // Filter by speed range (e.g., vehicles with a certain speed range)
        if (isset($filters['speed_range'])) {
            $query->where('speed_range', $filters['speed_range']);
        }
        // Filter by creator
        if (isset($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }
        // Filter by store
        if (isset($filters['store_id'])) {
            $query->where('store_id', $filters['store_id']);
        }

        // Filter by fuel type (multiple selections allowed)
        if (isset($filters['fuel_type'])) {
            $query->where('fuel_type', $filters['fuel_type']);
        }

        // Filter by maximum distance (e.g., minimum and maximum distance)
        if (isset($filters['min_distance'])) {
            $query->where('max_distance', '>=', $filters['min_distance']);
        }
        if (isset($filters['max_distance'])) {
            $query->where('max_distance', '<=', $filters['max_distance']);
        }

        // Filter by extra charge (e.g., vehicles with a certain charge or less)
        if (isset($filters['max_extra_charge'])) {
            $query->where('extra_charge', '<=', $filters['max_extra_charge']);
        }

        // Filter by average fuel cost (e.g., vehicles with a certain fuel cost range)
        if (isset($filters['min_fuel_cost'])) {
            $query->where('average_fuel_cost', '>=', $filters['min_fuel_cost']);
        }

        if (isset($filters['max_fuel_cost'])) {
            $query->where('average_fuel_cost', '<=', $filters['max_fuel_cost']);
        }

        // Filter by status (active or inactive vehicles)
        if (isset($filters['status'])) { // Check explicitly for 0 or 1
            $query->where('status', $filters['status']);
        }

        // Sort results (default to ascending order by name if not provided)
        if (isset($filters['sort_by']) && isset($filters['sort_order'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_order']);
        } else {
            $query->orderBy('name', 'asc');
        }

        // Pagination (default to 10 items per page if not provided)
        $perPage = $filters['per_page'] ?? 10;
        return $query->with('related_translations')->paginate($perPage);
    }

    public function addVehicle(array $data)
    {
        $data['created_by'] = auth('api')->user()->id;
        try {
            $data = Arr::except($data, ['translations']);
            $vehicle = VehicleType::create($data);
            return $vehicle->id;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function updateVehicle(array $data)
    {

        try {
            $data = Arr::except($data, ['translations']);
            $vehicle = VehicleType::findorfail($data['id']);
            $vehicle->update($data);
            return $vehicle->id;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getVehicleById(int $id)
    {
        try {
            $vehicle = VehicleType::with(['related_translations'])->find($id);
            if ($vehicle) {
                return $vehicle;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteVehicle(int $id)
    {
        try {
            $vehicle = VehicleType::findorfail($id);
            $vehicle->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getVehicleRequests()
    {
        try {
            $vehicles = VehicleType::inactiveVehicles()->paginate(10);
            return $vehicles;
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function approveVehicles(array $ids)
    {
        try {
            $vehicles = VehicleType::whereIn('id', $ids)
                ->where('status', 0)
                ->update(['status' => 1]);
            return $vehicles > 0;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function toggleVehicleStatus(int $id)
    {
        try {
            $vehicle = VehicleType::findOrFail($id);
            $vehicle->status = !$vehicle->status;
            $vehicle->save();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function vehicleTypeDropdown()
    {
        $vehicleTypes = VehicleType::where('status', 1)->get();
        if ($vehicleTypes->count() > 0) {
            return $vehicleTypes;
        } else {
            return false;
        }
    }

    // -------------------------------------------------------- Delivery man order manage ---------------------------------------------------
    public function deliverymanOrders()
    {
        $deliveryman = auth('api')->user();
        $orders = Order::where('confirmed_by', $deliveryman->id)
            ->latest()
            ->paginate(5);
        return $orders;
    }

    public function orderRequests()
    {
        $system_commission = SystemCommission::first();
        if (optional($system_commission)->order_confirmation_by === 'store') {
            return false;
        }
        $deliveryman = auth('api')->user();
        $order_requests = Order::with('orderDeliveryHistory')
            ->whereNull('confirmed_by')
            ->whereDoesntHave('orderDeliveryHistory', function ($query) use ($deliveryman) {
                $query->where('deliveryman_id', $deliveryman->id);
            })
            ->latest()
            ->paginate(10);
        return $order_requests;
    }

    public function updateOrderStatus(string $status, int $order_id, string $reason)
    {
        $deliveryman = auth('api')->user();
        DB::beginTransaction();

        try {
            $order = Order::find($order_id);
            if ($status === 'accepted') {
                if ($order->confirmed_by !== null) {
                    return 'already confirmed';
                }
                $order->update([
                    'confirmed_by' => $deliveryman->id,
                    'confirmed_at' => Carbon::now(),
                ]);
                OrderDeliveryHistory::create([
                    'order_id' => $order_id,
                    'deliveryman_id' => $deliveryman->id,
                    'status' => $status,
                ]);
            }
            if ($status === 'ignored') {
                if (!$reason) {
                    return 'reason is required';
                }
                OrderDeliveryHistory::create([
                    'order_id' => $order_id,
                    'deliveryman_id' => $deliveryman->id,
                    'reason' => $reason,
                    'status' => $status,
                ]);
            }

            DB::commit();
            return $status;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function orderChangeStatus(string $status, int $order_id, string $reason)
    {
        $deliveryman = auth('api')->user();
        DB::beginTransaction();

        try {
            $order = Order::find($order_id);
            if ($status === 'delivered') {
                if ($order->status === 'delivered') {
                    return 'already delivered';
                }
                $order->update([
                    'status' => 'delivered',
                    'delivery_completed_at' => Carbon::now(),
                ]);
                OrderDeliveryHistory::create([
                    'order_id' => $order_id,
                    'deliveryman_id' => $deliveryman->id,
                    'status' => $status,
                ]);


                // delivery man wallet update
               $wallet = Wallet::where('owner_id', $deliveryman->id)
                    ->where('owner_type', WalletOwnerType::DELIVERYMAN->value)
                    ->first();

               // create wallet history
               WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'amount' => $order->delivery_charge_admin, // Add only the deliveryman's earning
                    'type' => 'credit',
                    'purpose' => 'Delivery Earnings',
                    'status' => 1,
                ]);

                // send mail and notification

            }

            if ($status === 'cancelled') {
                if (!$reason) {
                    return 'reason is required';
                }
                OrderDeliveryHistory::create([
                    'order_id' => $order_id,
                    'deliveryman_id' => $deliveryman->id,
                    'reason' => $reason,
                    'status' => $status,
                ]);
            }

            DB::commit();
            return $status;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function deliverymanOrderHistory()
    {
        $deliveryman = auth('api')->user();

        if (!$deliveryman || $deliveryman->activity_scope !== 'delivery_level') {
            return 'unauthorized'; // Return 'unauthorized' if user is not a deliveryman
        }

        // Fetch the order history of the deliveryman with associated order details
        return OrderDeliveryHistory::with('order')
            ->where('deliveryman_id', $deliveryman->id)
            ->latest()
            ->paginate(10); // Paginate results
    }


    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        $translations = [];
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }
                    // Collect translation data
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }
        if (count($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }

    public function updateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        $translations = [];
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }

                    $trans = $this->translation->where('translatable_type', $refPath)->where('translatable_id', $refid)
                        ->where('language', $translation['language_code'])->where('key', $key)->first();
                    if ($trans != null) {
                        $trans->value = $translatedValue;
                        $trans->save();
                    } else {
                        $translations[] = [
                            'translatable_type' => $refPath,
                            'translatable_id' => $refid,
                            'language' => $translation['language_code'],
                            'key' => $key,
                            'value' => $translatedValue,
                        ];
                    }
                }
            }
        }
        if (count($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }

    public function deliverymanListDropdown(array $filter)
    {
        $query = User::with('deliveryman.area')->where('activity_scope', 'delivery_level');
        if (isset($filter['search'])) {
            $search = $filter['search'];
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
                $query->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }
        return $query->paginate(10);
    }
}
