<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\ComHelper;
use App\Models\ComStore;
use App\Models\CustomPermission;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PartnerLoginController extends Controller
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('activity_scope', 'store_level')
            ->where('status', 1)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["success" => false,"token" => null, "permissions" => []];
        }

        $email_verified = $user->hasVerifiedEmail();

        $storeIds = json_decode($user->stores);
        if (!is_null($storeIds) && is_array($storeIds)) {
            $stores = ComStore::whereIn('id', $storeIds)
                ->select(['id', 'name', 'store_type'])
                ->get()
                ->toArray();
        } else {
            $stores = [];
        }

        return [
            "success" => true,
            "token" => $user->createToken('auth_token')->plainTextToken,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email'    => $user->email,
            'phone'    => $user->phone,
            "email_verified" => $email_verified,
            "store_owner" => $user->store_owner,
            "merchant_id" => $user->merchant_id,
            "stores" => $stores,
            "role" => $user->getRoleNames()
        ];
    }

    public static function buildMenuTree($data_list)
    {
        $tree = [];
        foreach ($data_list as $data_item) {

            if(isset($data_item->children)) {
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
