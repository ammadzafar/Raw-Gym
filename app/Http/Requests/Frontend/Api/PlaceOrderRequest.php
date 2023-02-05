<?php

namespace App\Http\Requests\Frontend\Api;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => ['nullable', 'string'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'address' => ['required', 'string'],
            'variants' => ['required', 'array'],
            'variants.*.variant_id' => ['required', 'exists:variants,id'],
            'variants.*.quantity' => ['required', 'numeric', 'min:0'],
            'variants.*.unit_price' => ['required', 'numeric', 'min:0'],
            'variants.*.total_amount' => ['required', 'numeric', 'min:0'],
        ];
    }
}
