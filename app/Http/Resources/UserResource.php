<?php

namespace App\Http\Resources;

use App\Helpers\ComHelper;
use App\Models\ComMerchantStore;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $permissions=$this->rolePermissionsQuery()->whereNull('parent_id')->with('childrenRecursive')->get();
        $stores=[];
        if($this->stores!='') {
            $stores = ComMerchantStore::whereIn('id', json_decode($this->stores))
                ->select(['id', 'name','store_type'])
                ->get()
                ->toArray();
        }

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'activity_scope' => $this->activity_scope,
            'email_verified_at' => $this->email_verified_at,
            "store_owner" => $this->store_owner,
            "merchant_id" => $this->merchant_id,
            "stores" => $stores,
            'roles' => $this->roles->pluck('name'),
            "permissions" => ComHelper::buildMenuTree($this->roles->pluck('id')->toArray(),$permissions),
        ];
    }
}
