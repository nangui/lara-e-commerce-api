<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $resource = User::class;
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'users',
            'id' => (string) $this->id,
            'attributes' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
            ],
            'relationships' => [
                'role' => [
                    'data' => [
                        'id' => $this->role->id,
                        'name' => $this->role->name
                    ]
                ]
            ]
        ];
    }
}
