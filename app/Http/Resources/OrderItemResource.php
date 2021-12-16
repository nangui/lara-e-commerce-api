<?php

namespace App\Http\Resources;

use App\Models\OrderItem;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public $resource = OrderItem::class;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => 'order_items',
            'id' => $this->id,
            'attributes' => [
                'variationTitle' => $this->variation->name,
                'price' => (float) $this->price,
                'quantity' => (int) $this->quantity
            ]
        ];
    }
}
