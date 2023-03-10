<?php

namespace App\Http\Requests\Backend\PtfLog;

use Illuminate\Foundation\Http\FormRequest;

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
            'personal_training_fees' => ['nullable', 'integer'/*, 'required_if:personal_training,on'*/],

        ];
    }
}
