<?php

namespace App\Http\Requests\Backend\Membership;

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
            'name' => 'required|unique:memberships,name,' . $this->id,
            'fees' => 'required|integer|gt:-1',
            'reg_fee' => 'nullable|integer|gt:-1',
            'duration' => 'required|integer|gt:-1',
            'description'=>'required'
        ];
    }
}
