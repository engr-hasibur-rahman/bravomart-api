<?php

namespace App\Repositories;

use App\Interfaces\DeliverymanManageInterface;
use App\Models\DeliveryMan;
use App\Models\Translation;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

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
        $deliverymen = $query->paginate(isset($filters['per_page']) ?? 10);

        return $deliverymen;
    }

    public function store(array $data)
    {
        DB::beginTransaction();

        try {
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
                'vehicle_type_id' => $data['vehicle_type_id'],
                'area_id' => $data['area_id'] ?? null,
                'identification_type' => $data['identification_type'],
                'identification_number' => $data['identification_number'],
                'identification_photo_front' => $data['identification_photo_front'] ?? null,
                'identification_photo_back' => $data['identification_photo_back'] ?? null,
                'address' => $data['address'] ?? null,
                'created_by' => auth('sanctum')->id(),
            ]);

            if (!$deliverymanExtra) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return $deliveryman->id;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    public function update(array $data)
    {
        DB::beginTransaction();

        try {
            // Find the existing user record
            $user = User::find($data['id']);
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
                'email' => $data['email'],
                'activity_scope' => 'delivery_level',
                'password' => $data['password'] ?? $user->password,  // Keep old password if not provided
                'store_owner' => 0,
                'store_seller_id' => null,
                'stores' => null,
                'status' => $data['status'] ?? 0,
            ]);

            if (!$user->wasChanged()) {  // Check if anything was updated
                DB::rollBack();
                return false;
            }

            // Find and update the associated DeliveryMan record
            $deliveryman = DeliveryMan::where('user_id', $data['id'])->first();
            if (!$deliveryman) {
                DB::rollBack();
                return null;  // Return null if DeliveryMan does not exist
            }

            // Update the DeliveryMan extra details
            $deliveryman->update([
                'vehicle_type_id' => $data['vehicle_type_id'],
                'store_id' => $data['store_id'] ?? null,
                'area_id' => $data['area_id'] ?? null,
                'identification_type' => $data['identification_type'],
                'identification_number' => $data['identification_number'],
                'identification_photo_front' => $data['identification_photo_front'] ?? null,
                'identification_photo_back' => $data['identification_photo_back'] ?? null,
                'address' => $data['address'] ?? null,
                'updated_by' => auth('sanctum')->id(),
            ]);
            if (!$deliveryman->wasChanged()) {  // Check if anything was updated
                DB::rollBack();
                return false;
            }
            DB::commit();  // Commit transaction if all updates succeed
            return $user->id;  // Return user ID on success
        } catch (\Exception $exception) {
            DB::rollBack();  // Rollback on exception
            return null;
        }
    }

    public function getDeliverymanById(int $id)
    {
        try {
            $deliveryman = DeliveryMan::with('deliveryman', 'vehicle_type', 'area', 'creator', 'updater')
                ->findOrFail($id);
            return $deliveryman;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function delete(int $userId)
    {
        DB::beginTransaction();

        try {
            // Find the user record
            $user = User::find($userId);
            if (!$user) {
                DB::rollBack();
                return false;  // Return false if user does not exist
            }

            // Find and delete the associated DeliveryMan record
            $deliveryman = DeliveryMan::where('user_id', $userId)->first();
            if ($deliveryman) {
                // Delete the DeliveryMan record
                $deliveryman->delete();
            }

            // Delete the User record
            $user->delete();

            DB::commit();  // Commit transaction if both deletions succeed
            return true;  // Return true on success
        } catch (\Exception $exception) {
            DB::rollBack();  // Rollback on exception
            return false;  // Return false if an error occurs
        }
    }

    public function getDeliverymanRequests()
    {
        try {
            $deliverymen = DeliveryMan::with([
                'deliveryman',
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
        if (isset($filters['fuel_types']) && is_array($filters['fuel_types'])) {
            $query->whereIn('fuel_type', $filters['fuel_types']);
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
        $data['created_by'] = auth('sanctum')->id();
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
            $vehicle = VehicleType::with(['creator', 'related_translations'])->findorfail($id);
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
}
