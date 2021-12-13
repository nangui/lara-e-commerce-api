<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVariationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'us_size' => 'required|numeric',
            'euro_size' => 'required|numeric',
            'uk_size' => 'required|numeric',
            'color_name' => 'required|string',
            'color_code' => 'required|string|min:7|max:7',
            'price' => 'required|numeric',
            'images' => 'required'
        ];
    }
}
