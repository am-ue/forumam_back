<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
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
        $this->redirectAfterLogout = config('app.protocol').'://'.config('app.domain');
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->route('admin.login')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    protected function getRedirectUrl()
    {
        return action('Admin\Auth\AuthController@showLoginForm');
    }
}
