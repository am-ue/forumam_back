<?php

namespace App\Http\Requests;

class SignupRequest extends Request
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
            'company.name'    => 'required',
            'company.website' => 'required | url',
            'company.summary' => 'required',
            'user.first_name' => 'required',
            'user.last_name'  => 'required',
            'user.phone'      => 'required',
            'user.email'      => 'required|email|unique:users,email',
            'user.password'   => 'required|confirmed',
        ];
    }

    public function response(array $errors)
    {
        return response()->json([
            'code'   => 422,
            'errors' => $errors,
        ], 422);
    }
}
