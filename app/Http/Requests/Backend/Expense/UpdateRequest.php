<?php

namespace App\Http\Requests\Backend\Expense;

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
            //
            'date' => 'required',
            'expenses.*.amount' => 'required|integer|gte:0',
            'expenses.*.label' => 'required'
        ];
    }
}
