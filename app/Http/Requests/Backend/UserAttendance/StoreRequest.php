<?php

namespace App\Http\Requests\Backend\UserAttendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreRequest extends FormRequest
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
            'label'=>'required',
            'date'=>'required',
            'status'=>[
                'required',
                Rule::in(['present','absent','leave','public_holiday','weekend']),
            ]
        ];
    }
}
