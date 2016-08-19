<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $linkRequestView;
    protected $resetView;

    public function __construct()
    {
        $this->middleware('guest');
        $this->linkRequestView = 'admin.auth.passwords.email';
        $this->resetView = 'admin.auth.passwords.reset';
    }
}
