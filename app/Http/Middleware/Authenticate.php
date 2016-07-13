<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('admin.login'));
            }
        }

        if (!Auth::guard($guard)->user()->company->active) {
            Auth::guard($guard)->logout();
            $message = 'Vous n\'êtes pas autorisé à vous connecter.<br/> Merci de contacter un responsable du forum.';
            alert()->error($message, 'Désolé')->html()->persistent('Continuer');
            return redirect()->guest(route('admin.login'));
        }

        return $next($request);
    }
}
