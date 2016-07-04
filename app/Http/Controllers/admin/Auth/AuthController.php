<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo;
    protected $redirectAfterLogout;
    protected $loginView = 'admin.auth.login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = route('admin.home');
        $this->redirectAfterLogout = route('admin.login');
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
}
