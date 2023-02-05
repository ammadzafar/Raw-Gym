<?php

namespace App\Http\Requests\Backend\Users;

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
            'name' => "required|string|max:255",
            'email' => "required|email|unique:users,email," . $this->id,
            'phone' => "required|unique:users,phone," . $this->id,
            'role' => "required|integer|exists:roles,id",
            'dob' => "nullable|date|date_format:Y-m-d|before:today",
            'date' => "nullable|date|date_format:Y-m-d",
            'total_leaves' => "nullable|integer",
            'job_type' => "nullable|string",

            'shifts' => "nullable|required_if:employ_type,1|array",
            'salary' => "nullable|string|required_if:employ_type,1",
            'shifts.*.name' => "nullable|string|required_if:employ_type,1",
            'shifts.*.from' => "nullable|string|required_if:employ_type,1",
            'shifts.*.to' => "nullable|string|required_if:employ_type,1",

            'pt_percentage' => "nullable|integer|min:0|max:100|required_if:pt,1",
            'members' => "nullable|required_if:pt,1|array",
            'members.*' => "nullable|exists:members,id|required_if:pt,1",
        ];
    }
}
