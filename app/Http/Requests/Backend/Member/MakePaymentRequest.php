<?php

namespace App\Http\Requests\Backend\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MakePaymentRequest extends FormRequest
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
            'payment_method' => ['required', Rule::in(getPossibleEnumValues('fees', 'payment_method') ?? [])],
            'reg_fee' => ['nullable', 'integer', 'gt:-1'],
            'fees' => ['nullable', 'integer', 'gt:-1'],
            'pending_fees' => ['nullable', 'integer', 'gt:-1'],
            'personal_training_fees' => ['nullable', 'integer', 'gt:-1'],
            'pending_personal_training_fees' => ['nullable', 'integer', 'gt:-1'],
            'payment_date' => ['required', 'date', 'date_format:Y-m-d'],
            'notes' => ['required'],
        ];
    }
}
