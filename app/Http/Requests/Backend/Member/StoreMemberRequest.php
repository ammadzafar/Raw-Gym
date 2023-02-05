<?php

namespace App\Http\Requests\Backend\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class StoreMemberRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'unique:members,phone'],
            'email' => ['nullable', 'email', 'unique:members,email'],
            'dob' => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
            'membership_id' => ['nullable', 'integer', 'gte:0', 'exists:memberships,id', 'required_without:fee_structure'],
            'reg_fee' => ['nullable', 'integer', 'gte:0', /*'required_without:membership_id'*/],
            'fee_structure' => ['nullable', 'integer', 'gte:0', 'required_without:membership_id'],
            'personal_training_fees' => ['nullable', 'integer', 'gte:0', 'required_if:personal_training,on'],
            'in_house_training_fees' => ['nullable', 'integer', 'gte:0', 'required_if:in_house_training,on'],
            'personal_training' => ['nullable', 'in:on,off'],
            'in_house_training' => ['nullable', 'in:on,off'],
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:4096',
            'reg_date' => ['required', 'date', 'date_format:Y-m-d'],
            'classes_fees'=>['nullable', 'integer', 'gte:0']
        ];
    }
}
