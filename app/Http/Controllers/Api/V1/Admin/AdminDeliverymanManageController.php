<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliverymanRequest;
use App\Http\Requests\VehicleTypeRequest;
use App\Http\Resources\Admin\AdminDeliverymanDetailsResource;
use App\Http\Resources\Admin\AdminDeliverymanRequestResource;
use App\Http\Resources\Admin\AdminDeliverymanResource;
use App\Http\Resources\Admin\AdminVehicleDetailsResource;
use App\Http\Resources\Admin\AdminVehicleRequestResource;
use App\Http\Resources\Admin\AdminVehicleResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Deliveryman\DeliverymanDropdownResource;
use App\Interfaces\DeliverymanManageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminDeliverymanManageController extends Controller
{
    public function __construct(protected DeliverymanManageInterface $deliverymanRepo)
    {

    }

    public function index(Request $request)
    {

        $filters = [
            'search' => $request->input('search', null),
            'vehicle_type_id' => $request->input('vehicle_type_id', null),
            'area_id' => $request->input('area_id', null),
            'status' => $request->input('status', null),
            'identification_type' => $request->input('identification_type', null),
            'created_by' => $request->input('created_by', null),
            'per_page' => $request->input('per_page')
        ];
        $deliverymen = $this->deliverymanRepo->getAllDeliveryman($filters);
        return response()->json([
            'data' => AdminDeliverymanResource::collection($deliverymen),
            'meta' => new PaginationResource($deliverymen)
        ]);
    }

    public function store(DeliverymanRequest $request)
    {
        $deliveryman = $this->deliverymanRepo->store($request->all());
        if ($deliveryman) {
            return response()->json([
                'message' => __('messages.save_success', ['name' => 'Deliveryman'])
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.save_failed', ['name' => 'Deliveryman'])
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'status' => 'nullable|integer',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'area_id' => 'nullable|exists:areas,id',
            'address' => 'nullable|string|max:255',
            'identification_type' => 'nullable',
            'identification_number' => 'nullable',
            'identification_photo_front' => 'nullable',
            'identification_photo_back' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deliveryman = $this->deliverymanRepo->update($request->all());
        if ($deliveryman) {
            return $this->success(__('messages.update_success', ['name' => 'Deliveryman']));
        } else {
            return $this->failed(__('messages.update_failed', ['name' => 'Deliveryman']));
        }
    }

    public function show(Request $request)
    {
        $deliveryman = $this->deliverymanRepo->getDeliverymanById($request->id);
        if ($deliveryman) {
            return response()->json(new AdminDeliverymanDetailsResource($deliveryman));
        } else {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }

    }

    public function destroy(int $id)
    {
        $deleted = $this->deliverymanRepo->delete($id);
        if ($deleted) {
            return $this->success(__('messages.delete_success', ['name' => 'Deliveryman']));
        } else {
            return $this->failed(__('messages.delete_failed', ['name' => 'Deliveryman']));
        }
    }

    public function deliverymanRequest()
    {
        $deliverymen = $this->deliverymanRepo->getDeliverymanRequests();
        if ($deliverymen) {
            return response()->json([
                'data' => AdminDeliverymanRequestResource::collection($deliverymen),
                'meta' => new PaginationResource($deliverymen),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
            ]);
        }
    }

    public function approveRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deliveryman_ids*' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $success = $this->deliverymanRepo->approveDeliverymen($request->deliveryman_ids);
        if ($success) {
            return $this->success(__('messages.approve.success', ['name' => 'Deliveryman requests']));
        } else {
            return $this->failed(__('messages.approve.failed', ['name' => 'Deliveryman requests']));
        }
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deliveryman_ids*' => 'required|array',
            'status' => 'required|integer|in:0,1,2',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $success = $this->deliverymanRepo->changeStatus($request->all());
        if ($success) {
            return $this->success(__('messages.update_success', ['name' => 'Deliveryman status']));
        } else {
            return $this->failed(__('messages.update_failed', ['name' => 'Deliveryman status']));
        }
    }

    public function indexVehicle(Request $request)
    {
        $filters = [
            'search' => $request->input('search', null),
            'min_capacity' => $request->input('min_capacity', null),
            'max_capacity' => $request->input('max_capacity', null),
            'speed_range' => $request->input('speed_range', null),
            'created_by' => $request->input('created_by', null),
            'store_id' => $request->input('store_id', null),
            'fuel_types' => $request->input('fuel_types', []),
            'min_distance' => $request->input('min_distance', null),
            'max_distance' => $request->input('max_distance', null),
            'max_extra_charge' => $request->input('max_extra_charge', null),
            'min_fuel_cost' => $request->input('min_fuel_cost', null),
            'max_fuel_cost' => $request->input('max_fuel_cost', null),
            'status' => $request->input('status', null),
            'sort_by' => $request->input('sort_by', 'name'),
            'sort_order' => $request->input('sort_order', 'asc'),
            'per_page' => $request->input('per_page', 10),
        ];
        $vehicles = $this->deliverymanRepo->getAllVehicles($filters);
        return response()->json(
            [
                'data' => AdminVehicleResource::collection($vehicles),
                'meta' => new PaginationResource($vehicles),
            ]
        );
    }

    public function storeVehicle(VehicleTypeRequest $request)
    {
        $vehicle = $this->deliverymanRepo->addVehicle($request->all());
        $this->deliverymanRepo->storeTranslation($request, $vehicle, 'App\Models\VehicleType', $this->deliverymanRepo->translationKeys());
        if ($vehicle) {
            return $this->success(__('messages.save_success', ['name' => 'Vehicle type']));
        } else {
            return $this->failed(__('messages.save_failed', ['name' => 'Vehicle type']));
        }
    }

    public function showVehicle(Request $request)
    {

        $vehicle = $this->deliverymanRepo->getVehicleById($request->id);
        if ($vehicle) {
            return response()->json(new AdminVehicleDetailsResource($vehicle));
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
            ]);
        }
    }

    public function updateVehicle(VehicleTypeRequest $request)
    {
        $vehicle = $this->deliverymanRepo->updateVehicle($request->all());
        $this->deliverymanRepo->updateTranslation($request, $vehicle, 'App\Models\VehicleType', $this->deliverymanRepo->translationKeys());
        if ($vehicle) {
            return $this->success(__('messages.update_success', ['name' => 'Vehicle type']));
        } else {
            return $this->failed(__('messages.update_failed', ['name' => 'Vehicle type']));
        }
    }

    public function destroyVehicle(int $id)
    {
        $success = $this->deliverymanRepo->deleteVehicle($id);
        if ($success) {
            return $this->success(__('messages.delete_success', ['name' => 'Vehicle type']));
        } else {
            return $this->failed(__('messages.delete_failed', ['name' => 'Vehicle type']));
        }
    }

    public function vehicleRequest()
    {
        $vehicles = $this->deliverymanRepo->getVehicleRequests();
        if ($vehicles) {
            return response()->json([
                'data' => AdminVehicleRequestResource::collection($vehicles),
                'meta' => new PaginationResource($vehicles),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
            ]);
        }
    }

    public function approveVehicleRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids*' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // HTTP status code 422 for validation errors
        }
        $success = $this->deliverymanRepo->approveVehicles($request->ids);
        if ($success) {
            return $this->success(__('messages.approve.success', ['name' => 'Vehicle type requests']));
        } else {
            return $this->failed(__('messages.approve.failed', ['name' => 'Vehicle type requests']));
        }
    }

    public function changeVehicleStatus(Request $request)
    {
        $success = $this->deliverymanRepo->toggleVehicleStatus($request->id);
        if ($success) {
            return $this->success(__('messages.update_success', ['name' => 'Vehicle type status']));
        } else {
            return $this->failed(__('messages.update_failed', ['name' => 'Vehicle type status']));
        }
    }

    public function deliverymanDropdownList(Request $request)
    {
        $filter = [
            'search' => $request->search,
        ];
        $deliverymen = $this->deliverymanRepo->deliverymanListDropdown($filter);
        if ($deliverymen->isEmpty()) {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], 404);
        }
        return response()->json([
            'data' => DeliverymanDropdownResource::collection($deliverymen)
        ], 200);
    }
}
