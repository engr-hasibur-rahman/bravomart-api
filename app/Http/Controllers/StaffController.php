<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerStaffStoreRequest;
use App\Http\Resources\Staff\SellerStaffDetailsResource;
use App\Repositories\UserRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role as UserRole;
use App\Http\Requests\UserCreateRequest;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $roles = QueryBuilder::for(User::class)
            ->with(['permissions'])
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            })
            ->paginate($limit);

        return UserResource::collection($roles);
    }

    public function store(SellerStaffStoreRequest $request)
    {
        try {
            // Check for not allowed roles
            $notAllowedRoles = [UserRole::SUPER_ADMIN];
            if (
                (isset($request->roles->value) && in_array($request->roles->value, $notAllowedRoles)) ||
                (isset($request->roles) && in_array($request->roles, $notAllowedRoles))
            ) {
                throw new AuthorizationException(__('messages.authorization_invalid'));
            }

            // Fetch default roles
            $roles = Role::where('available_for', 'store_level')
                ->where('name', '!=', 'Store Admin')
                ->where('status', 1)
                ->pluck('name')
                ->toArray();

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
                'image' => $request->image,
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
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => __('messages.validation_failed'),
                "errors" => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Catch unexpected errors
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => __('messages.error'),
            ], 500);
        }
    }

    public function show(string $id)
    {
        $user = User::with('permissions')->findOrFail($id);
        return new UserResource($user);
    }

    public function changeStatus(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'id' => 'required|exists:users,id',
                'status' => 'required|boolean',
            ]);

            // Find the user and update status
            $user = User::findOrFail($request->id);
            $user->status = $request->status;
            $user->save();

            // Return success response
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __("messages.status_change_success"),
            ], 200);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => __("messages.validation_failed"),
                "errors" => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Catch any other unexpected errors
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => __("messages.error"),
            ], 500);
        }
    }
    public function update(SellerStaffStoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $roles = [];
            if (isset($request->roles)) {
                $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
            }

            // Find the user and update details
            $user = User::findOrFail($request->id);
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
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'status' => false,
                'status_code' => 422,
                'message' => __('messages.update_failed', ['name' => 'Staff']),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Catch any other unexpected errors
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.error'),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
