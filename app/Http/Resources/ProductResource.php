<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public $resource = Product::class;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => 'products',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'slug' => $this->slug,
                'description' => $this->description,
                'specifications' => $this->specifications
            ],
            'relationships' => [
                'category' => [
                    'data' => [
                        'name' => $this->category->name,
                        'slug' => $this->category->slug
                    ]
                ],
                'variations' => [
                    'data' => $this->variations
                ]
            ]
        ];
    }
}
