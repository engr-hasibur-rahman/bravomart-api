<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\ImageModifier;
use App\Helpers\ComHelper;
use App\Models\Store;
use App\Models\CustomPermission;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PartnerLoginController extends Controller
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::where('email', $request->email)
            ->where('activity_scope', 'store_level')
            ->where('status', 1)
            ->first();
        if (!$user) {
            return response()->json([
                "status" => false,
                "status_code" => 422,
                "message" => 'User is not a seller!',
            ]);
        }
        // Check if the user's account is deleted
        if ($user->deleted_at !== null) {
            return response()->json([
                'error' => 'Your account has been deleted. Please contact support.'
            ], Response::HTTP_GONE); // HTTP 410 Gone
        }
        // Check if the user's account is deactivated or disabled
        if ($user->status === 0) {
            return response()->json([
                'error' => 'Your account has been deactivated. Please contact support.'
            ], Response::HTTP_FORBIDDEN); // HTTP 403 Forbidden
        }
        if ($user->status === 2) {
            return response()->json([
                'error' => 'Your account has been suspended by the admin.'
            ], Response::HTTP_FORBIDDEN); // HTTP 403 Forbidden
        }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["success" => false, "token" => null, "permissions" => []];
        }
        $email_verified = $user->hasVerifiedEmail();
        if (is_string($user->stores)) {
            $storeIds = json_decode($user->stores, true); // Decodes JSON string to an array
        } elseif (is_array($user->stores)) {
            $storeIds = $user->stores; // It's already an array, no decoding needed
        } else {
            $storeIds = []; // Default to an empty array if the type is neither string nor array
        }
        if (!is_null($storeIds) && is_array($storeIds)) {
            $stores = Store::whereIn('id', $storeIds)
                ->select(['id', 'name', 'store_type'])
                ->get()
                ->toArray();
        } else {
            $stores = [];
        }
        // Handle the "Remember Me" option
        $remember_me = $request->has('remember_me');

        // Set token expiration dynamically
        config(['sanctum.expiration' => $remember_me ? null : env('SANCTUM_EXPIRATION')]);
        // update firebase device token
        $user->update([
            'firebase_token' => $request->firebase_device_token,
        ]);
        return [
            "success" => true,
            "message" => __('messages.login_success', ['name' => 'Seller']),
            "token" => $user->createToken('auth_token')->plainTextToken,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'image_url' => ImageModifier::generateImageUrl($user->image),
            "email_verified" => $email_verified,
            "store_owner" => $user->store_owner,
            "store_seller_id" => $user->store_seller_id,
            "stores" => $stores,
            "role" => $user->getRoleNames()
        ];
    }

    public static function buildMenuTree($data_list)
    {
        $tree = [];
        foreach ($data_list as $data_item) {

            if (isset($data_item->children)) {
                $children = $data_item->children->count() ? ComHelper::buildMenuTree($data_item->children) : [];
                $tree[] = [
                    'id' => $data_item->id,
                    'perm_title' => $data_item->perm_title,
                    'children' => $children,
                ];
            }
        }
        return $tree;
    }

}
