<?php

namespace Abdul\RolePermission;

use Abdul\RolePermission\Commands\PermissionsGenerator;
use Abdul\RolePermission\Middleware\AuthRoles;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class RolePermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *@param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__."/Database/migrations");
        $this->loadRoutesFrom(__DIR__."/routes/web.php");
        $this->loadViewsFrom(__DIR__.'/resources/views', 'rolepermission');
        if ($this->app->runningInConsole()) {
            // publish config file

            $this->commands([
                PermissionsGenerator::class,
            ]);
        }
        $router->aliasMiddleware('auth.role', AuthRoles::class);
        //dd("inside provider");
    }
}
