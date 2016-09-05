<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SignupRequest;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;

class SignupController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $company = new Company($request->input('company'));
        $company->public = false;
        $company->active = false;
        $company->save();

        $user = new User($request->input('user'));
        $user->password = $request->input('user.password');
        $user->company_id = $company->id;
        $user->save();

        return response()->json([
            'code' => 200,
            'message' => 'Votre inscription a été effectuée.
                Un membre de l\'équipe Forum vous recontactera dès que possible.'
        ]);
    }
}
