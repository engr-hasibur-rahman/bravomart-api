<?php

namespace App\Http\Controllers;

use App\Actions\ImageModifier;
use App\Enums\Role as UserRole;
use App\Http\Requests\SellerStaffStoreRequest;
use App\Http\Resources\Staff\SellerStaffDetailsResource;
use App\Http\Resources\UserDetailsResource;
use App\Http\Resources\UserResource;
use App\Models\Store;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class StaffController extends Controller
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $roles = QueryBuilder::for(User::class)
            ->with(['permissions'])
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->paginate($per_page);

        return UserResource::collection($roles);
    }

    public function store(SellerStaffStoreRequest $request)
    {

        // Check for not allowed roles
        $notAllowedRoles = [UserRole::SUPER_ADMIN];
        if (
            (isset($request->roles->value) && in_array($request->roles->value, $notAllowedRoles)) ||
            (isset($request->roles) && in_array($request->roles, $notAllowedRoles))
        ) {
            throw new AuthorizationException(__('messages.authorization_invalid'));
        }

//        // Fetch default roles
//        $roles = Role::where('available_for', 'store_level')
//            ->where('name', '!=', 'Store Admin')
//            ->where('status', 1)
//            ->pluck('name')
//            ->toArray();

        // Add role from request if provided
        if (isset($request->roles)) {
            $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
        }

        // Create user
        $user = $this->repository->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'slug' => username_slug_generator($request->first_name, $request->last_name),
            'activity_scope' => 'store_level',
            'stores' => json_encode($request->stores), // Encode as JSON if needed
            'store_seller_id' => auth()->guard('api')->user()->id, // Authenticated store admin id is seller ID
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => ImageModifier::generateImageUrl($request->image),
            'status' => 1,
            'password' => Hash::make($request->password),
        ]);


        // Assign roles to the user
        $user->assignRole($roles);

        // Return success response
        return response()->json([
            "message" => __('messages.registration_success', ['name' => 'Staff']),
            "user" => new SellerStaffDetailsResource($user),
        ], 201);

    }

    public function show(Request $request)
    {
        $validator = Validator::make(['id' => $request->id], [
            'id' => 'required|exists:users,id',
        ]);
        $user = User::with('permissions')->findOrFail($request->id);
        return response()->json(new UserDetailsResource($user));
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $seller = auth('api')->user();
        $seller_stores = Store::where('store_seller_id', $seller->id)->pluck('id')->toArray();

        $user = User::find($request->id);
        if ($user->stores == null) {
            return response()->json([
                'message' => __('messages.staff_not_assign_to_stores'),
            ], 422);
        }
        $user_stores = json_decode($user->stores, true);

        $user_is_your_staff = !empty(array_intersect($seller_stores, $user_stores));

        if (!$user_is_your_staff) {
            return response()->json([
                'message' => __('messages.staff_doesnt_belongs_to_seller'),
            ], 422);
        }
        if ($user) {
            $user->status = !$user->status;
            $user->save();

            // Return success response
            return response()->json([
                "message" => __("messages.status_change_success"),
            ], 200);
        } else {
            return response()->json([
                "message" => __("messages.data_not_found"),
            ], 404);
        }
    }

    public function update(SellerStaffStoreRequest $request)
    {

        $validatedData = $request->validated();
        $roles = [];
        if (isset($request->roles)) {
            $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
        }

        // Find the user and update details
        $user = User::find($request->id);
        if ($user) {
            // Update user details
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
            $user->slug = username_slug_generator($validatedData['first_name'], $validatedData['last_name']);
            $user->email = $validatedData['email'];
            $user->phone = $validatedData['phone'];
            $user->stores = json_encode($validatedData['stores']);  // Store as JSON
            $user->store_seller_id = auth()->guard('api')->user()->id;  // Set authenticated seller's ID
            $user->activity_scope = 'store_level';  // Assuming it's constant for all users
            $user->image = $validatedData['image'] ?? null; // Default status, assuming active
            $user->status = 1;  // Default status, assuming active

            // Update password only if provided
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();

            // Sync roles with the user
            if (!empty($roles)) {
                $user->syncRoles($roles);
            }

            // Return success response with user data
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.update_success', ['name' => 'Staff']),
            ]);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make(['id' => $request->id], [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $staff = User::find($request->id);
        if (!$staff) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        if ($staff) {
            $staff->delete();
            return response()->json([
                'message' => __('messages.delete_success', ['name' => 'Staff']),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.delete_failed', ['name' => 'Staff']),
            ], 500);
        }
    }
}
