<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class Api
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
        Company::addGlobalScope('showable', function (Builder $builder) {
            $builder->showable();
        });

        return $next($request);
    }
}
