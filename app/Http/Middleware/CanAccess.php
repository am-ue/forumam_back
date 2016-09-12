<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\User;
use Auth;
use Closure;
use Route;

class CanAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isAuthorized = Auth::user()->isAdmin()
            || $this->isRequestedEqualsCurrentUser()
            || $this->isRequestedEqualsCurrentCompany()
        ;
        if (!$isAuthorized) {
            alert()->error('Vous n\'êtes pas autorisé à consulter cette page.', 'Désolé')->persistent('Continuer');
            return redirect()->route('admin.home');
        }
        return $next($request);
    }

    protected function isRequestedEqualsCurrentUser()
    {
        $user = Route::getCurrentRoute()->parameter('user');
        if (!$user) {
            return false;
        }
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $user == Auth::user()->id;
    }

    protected function isRequestedEqualsCurrentCompany()
    {
        $company = Route::getCurrentRoute()->parameter('company');
        if (!$company) {
            return false;
        }

        if ($company instanceof Company) {
            $company = $company->id;
        }
        return $company == Auth::user()->company_id;
    }
}
