<?php

namespace App\Http\Resources;

use App\Models\ComStore;
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

        $permissions=[];
        //Take Individual Permission
        $permissions_indv = $this->permissions->map(function ($permission) {
            return [
                'group' => $permission->module,
                'group_title' => $permission->module_title,
                'perm_name' => $permission->name,
                'perm_title' => $permission->perm_title,
            ];
        })->toArray();

        //Get Role Permission and Merge Them
        foreach ($this->roles as $role) {
            $permissions = array_merge($permissions_indv,$role->permissions->map(function ($permission) {
                return [
                    'group' => $permission->module,
                    'group_title' => $permission->module_title,
                    'perm_name' => $permission->name,
                    'perm_title' => $permission->perm_title,
                ];
            })->toArray());
        }

        $stores = ComStore::whereIn('id', json_decode($this->stores))
            ->select(['id', 'name'])
            ->get()
            ->toArray();

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
            'permissions' => $permissions,
        ];
    }
}
