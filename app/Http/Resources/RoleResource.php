<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public $resource = Role::class;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => 'roles',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name
            ],
            'relationships' => [
                'permissions' => [
                    'data' => $this->permissions
                ]
            ]
        ];
    }
}
