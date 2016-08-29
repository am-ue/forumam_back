<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{

    public function index()
    {
        return response()->json(Company::showable()->get());
    }

    public function show(Company $company)
    {
        return response()->json($company);
    }
}
