<?php

namespace App\Http\Requests\Backend\Member;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
            'phone' => ['required', 'unique:members,phone,' . $this->id],
            'email' => ['required', 'email', 'unique:members,email,' . $this->id],
            'dob' => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
            'member_type' => ['required'],
            'membership_id' => ['required_if:member_type,membership'],
            //'fee_structure' => ['nullable', 'integer', 'required_without:membership_id'],
          //  'personal_training_fees' => ['nullable', 'integer', 'required_if:personal_training,on'],
           // 'personal_training' => ['nullable', 'in:on,off'],
            'image'=>'image|mimes:jpeg,jpg,png,gif|max:4096',
            'reg_date' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
