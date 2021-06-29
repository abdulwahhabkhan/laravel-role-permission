<?php

namespace Abdul\RolePermission\Commands;

use Abdul\RolePermission\Models\Role;
use Abdul\RolePermission\Models\Permission;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class PermissionsGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate routes for roles permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Permission generator start ...");
        $options = $this->options();
        if ($options['fresh']){
            User::query()->update(['role_id'=>null]);
            Permission::query()->delete();
            Role::query()->delete();
        }

        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route){
            $action = $route->getActionname();
            $middlewere = $this->getMiddleware($route);
            if($action == "Closure" || $middlewere != 1){
                continue;
            }
            $name =  $route->getName();
            $module = $route->getAction('module');
            $section = $route->getAction('prefix');
            $section = $section ?? $module;
            $module = $module ?? 'Modules';
            $section = str_replace(['/'], '', $section);
            $this->info($action."---".$module."---".$name."---".$section."--".$middlewere);
            if(!$name)
                continue;
            
            $path = Permission::firstOrCreate(['action' =>$action, 'name' =>$name, 'module' =>$module, 'section' =>$section]);
            if(key_exists('role', $route->action)){
                $role = $route->action['role'];
                $role = Role::firstOrCreate(['name'=> $role]);
                $role->permissions()->syncWithoutDetaching($path->id);
            }
        }
        Cache::flush();
        $this->info("Permission generator end ...");
        return 0;
    }

    /**
     * @param $route
     *
     * @return bool
     */
    public function getMiddleware($route)
    {
        $middlewares = $route->getAction('middleware');
        return in_array('auth.role', $middlewares);
    }
}
