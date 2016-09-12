<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        $router->singularResourceParameters();
        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapAdminRoutes($router);
        $this->mapApiRoutes($router);
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapAdminRoutes(Router $router)
    {
        $domain = config('admin.subdomain') ?
            config('admin.subdomain').'.'.config('app.domain') :
            config('app.domain');
        $router->group([
            'domain'     => $domain,
            'prefix' => config('admin.path'),
            'as'         => 'admin.',
            'namespace'  => 'App\Http\Controllers\Admin',
            'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/Routes/admin.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function mapApiRoutes(Router $router)
    {
        $router->group([
            'domain'     => config('app.api_subdomain').'.'.config('app.domain'),
            'namespace'  => 'App\Http\Controllers\Api',
            'as'         => 'api.',
            'middleware' => 'api',
        ], function ($router) {
            require app_path('Http/Routes/api.php');
        });
    }
}
