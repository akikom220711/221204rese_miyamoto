<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageRequest extends FormRequest
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
            'manager_name' => 'required|string|max:191',
            'manager_email' => 'required|email|unique:managers,email|string|max:191',
            'manager_password' => 'required|min:8|max:191'
        ];
    }
}
