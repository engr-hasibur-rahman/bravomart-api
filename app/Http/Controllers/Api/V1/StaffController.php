<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Role as UserRole;
use App\Http\Requests\SellerStaffStoreRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Staff\SellerStaffDetailsResource;
use App\Http\Resources\UserDetailsResource;
use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\Store;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\MediaService;
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

        $query = QueryBuilder::for(User::class)
            ->with(['permissions'])
            ->when($request->filled('available_for'), function ($query) use ($request) {
                $query->where('available_for', $request->available_for);
            });

        if (auth('api')->user()->activity_scope == 'system_level') {
            $query->where('activity_scope', 'system_level');
        }
        if (auth('api')->user()->activity_scope == 'store_level' && auth('api')->user()->store_owner == 1) {
            $seller_stores = Store::where('store_seller_id', auth('api')->user()->id)->pluck('id')->toArray();

            $query->where(function ($q) use ($seller_stores) {
                foreach ($seller_stores as $storeId) {
                    // Use `LIKE` to search for the storeId in the format of "[1,2,3]"
                    $q->orWhere('stores', 'LIKE', '%[' . $storeId . ']%')
                        ->orWhere('stores', 'LIKE', '%,"' . $storeId . '"%')
                        ->orWhere('stores', 'LIKE', '%"' . $storeId . '"%')
                        ->orWhere('stores', 'LIKE', $storeId);
                }
            });
        }
        if (isset($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%'); // add other fields if needed
            });
        }
        $roles = $query->latest()->paginate($per_page);

        return response()->json([
            'data' => UserResource::collection($roles),
            'meta' => new PaginationResource($roles)
        ]);
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

        // Add role from request if provided
        if (isset($request->roles)) {
            $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
        }
        $isAdmin = auth('api')->user()->activity_scope == 'system_level';
        // Create user
        $user = $this->repository->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'slug' => username_slug_generator($request->first_name, $request->last_name),
            'activity_scope' => $isAdmin ? 'system_level' : 'store_level',
            'stores' => $isAdmin ? null : $request->stores, // Encode as JSON if needed
            'store_seller_id' => $isAdmin ? null : auth()->guard('api')->user()->id, // Authenticated store admin id is seller ID
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $request->image,
            'status' => 1,
            'password' => Hash::make($request->password),
        ]);


        // Assign roles to the user
        $user->assignRole($roles);

        // Update media record for this user's image if exists
        if (!empty($request->image)) {
            $media = Media::find($request->image);
            if ($media) {
                $media->update([
                    'user_id' => $user->id,
                    'user_type' => get_class($user),
                    'usage_type' => 'profile_picture',
                ]);
            }
        }

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
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
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
        $staff = User::find($request->id);
        if ($staff->locked) {
            return response()->json([
                'message' => __('messages.staff_can\'t_be_modified', ['reason' => 'This staff has assigned for super admin.', 'action' => 'edited']),
            ],403);
        }
        if (auth('api')->user()->activity_scope == 'store_level') {
            $seller = auth('api')->user();
            $seller_stores = Store::where('store_seller_id', $seller->id)->pluck('id')->toArray();

            $user = User::find($request->id);
            if ($user->stores == null) {
                return response()->json([
                    'message' => __('messages.staff_not_assign_to_stores'),
                ], 422);
            }
            $user_stores = $user->stores; // Already an array like ["1", "2"]

            $user_is_your_staff = !empty(array_intersect($seller_stores, $user_stores));

            if (!$user_is_your_staff) {
                return response()->json([
                    'message' => __('messages.staff_doesnt_belongs_to_seller'),
                ], 422);
            }
        } else {
            $user = User::find($request->id);
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

        // Check for not allowed roles
        $notAllowedRoles = [UserRole::SUPER_ADMIN];
        if (
            (isset($request->roles->value) && in_array($request->roles->value, $notAllowedRoles)) ||
            (isset($request->roles) && in_array($request->roles, $notAllowedRoles))
        ) {
            throw new AuthorizationException(__('messages.authorization_invalid'));
        }

        // Get the role from request
        $roles = [];
        if (isset($request->roles)) {
            $roles[] = isset($request->roles->value) ? $request->roles->value : $request->roles;
        }

        $isAdmin = auth('api')->user()->activity_scope == 'system_level';

        // Find the user
        $user = User::find($request->id);
        if ($user->locked) {
            return response()->json([
                'message' => __('messages.staff_can\'t_be_modified', ['reason' => 'This staff has assigned for super admin.', 'action' => 'edited']),
            ],403);
        }
        if (!$user) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }

        // Update user data
        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->stores = $isAdmin ? null : $validatedData['stores'];
        $user->store_seller_id = $isAdmin ? null : auth()->guard('api')->user()->id;
        $user->activity_scope = $isAdmin ? 'system_level' : 'store_level';
        $user->image = $validatedData['image'] ?? null;

        // Update password only if provided
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        // Sync roles if provided
        if (!empty($roles)) {
            $user->syncRoles($roles);
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.update_success', ['name' => 'Staff']),
            'user' => new SellerStaffDetailsResource($user),
        ]);
    }


    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $users = User::whereIn('id', $request->ids)->get();

        $mediaIds = [];
        $deleted = 0;
        $skipped = 0;

        foreach ($users as $user) {
            // Skip locked users (e.g., super admins)
            if ($user->locked) {
                $skipped++;
                continue;
            }

            try {
                // Collect media ID (e.g., profile image)
                if ($user->image) {
                    $mediaIds[] = $user->image;
                }

                // Delete permissions (assuming hasMany or belongsToMany)
                $user->permissions()->delete(); // or $user->permissions()->detach()

                // Delete user
                $user->delete();

                $deleted++;
            } catch (\Throwable $e) {
                $skipped++;
            }
        }

        // Delete all related media
        $mediaService = app(MediaService::class);
        $mediaResult = $mediaService->bulkDeleteMediaImages(array_unique($mediaIds));

        return response()->json([
            'success' => true,
            'message' => __('messages.delete_success', ['name' => 'Staff']),
            'deleted_staff' => $deleted,
            'skipped_staff' => $skipped,
            'deleted_media' => $mediaResult['deleted'],
            'failed_media' => $mediaResult['failed'],
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $staff = User::where('id', $request->user_id)->first();
        if ($staff->locked) {
            return response()->json([
                'message' => __('messages.staff_can\'t_be_modified', ['reason' => 'This staff has assigned for super admin.', 'action' => 'edited']),
            ],403);
        }
        $staff = $this->change_password($request->user_id, $request->password);
        if ($staff) {
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Staff password']),
            ]);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ]);
        }
    }

    private function change_password(int $user_id, string $password)
    {
        if (auth('api')->check()) {
            unauthorized_response();
        }
        $user = User::where('id', $user_id)->first();
        if (!$user) {
            return [];
        }
        $user->password = Hash::make($password);
        $user->save();
        return $user;
    }
}
