<?php

namespace App\Http\Resources;

use App\Models\Variation;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    public $resource = Variation::class;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => 'variations',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'sizes' => [
                    'us' => $this->us_size,
                    'uk' => $this->uk_size,
                    'euro' => $this->euro_size
                ],
                'color' => [
                    'name' => $this->color_name,
                    'code' => $this->color_code
                ]
            ],
            'relationships' => [
                'product' => [
                    'data' => [
                        'title' => $this->product->title,
                        'slug' => $this->product->slug
                    ]
                ]
            ]
        ];
    }
}
