<?php

namespace App\Http\Requests\Backend\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'unique:products,name,' . $this->id],
            'slug' => ['nullable', 'unique:products,slug,' . $this->id],
            'brand_id' => ['required', 'exists:brands,id'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'exists:categories,id'],
            'variants' => ['required', 'array'],
            'variants.*' => ['required', 'array'],
            'variants.*.price' => ['required', 'integer'],
            'variants.*.sku' => ['required', 'string'],
            'variants.*.stock' => ['required', 'integer'],
            'variants.*.status' => ['required', 'in:in_stock,out_of_stock'],
            'variants.*.values' => ['required', 'array'],
            'variants.*.values.*' => ['required', 'exists:values,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
        ];
    }
}
