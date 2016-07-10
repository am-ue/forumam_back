<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserStoreRequest extends Request
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'role'  => 'required',
            'phone'  => 'required',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed',
            'company_id'       => 'required|exists:companies,id',
        ];
    }
}
