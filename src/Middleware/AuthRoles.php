<?php

namespace Abdul\RolePermission\Middleware;

use Abdul\RolePermission\Exceptions\UnauthorizedException;
use Abdul\RolePermission\Models\Role;
use Closure;

class AuthRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, Closure $next)
    {
        $name = $request->route()->getName();
        $role_id = auth()->user()->role_id;
        $permissions = Role::rolePermissions($role_id);
        $permission = array_key_exists($name, $permissions);

        throw_if(!$permission, UnauthorizedException::noPermission());

        return $next($request);
    }
}
