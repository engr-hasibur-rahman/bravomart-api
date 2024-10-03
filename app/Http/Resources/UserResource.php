<?php

namespace App\Http\Resources;

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
        $permissions = [];
        $permissions = $this->permissions->pluck('name')->toArray();

        foreach ($this->roles as $role) {
            $permissions = array_merge($permissions, $role->permissions->pluck('name')->toArray());
        }

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'permissions' => $permissions,
            'roles' => $this->roles->pluck('name'),
            'is_active' => $this->is_active,
        ];
    }
}
