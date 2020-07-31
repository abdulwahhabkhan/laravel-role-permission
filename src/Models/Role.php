<?php

namespace Abdul\RolePermission\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    protected static $cache_prefix = "auth.role";

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return  $this->hasMany(User::class);
    }

    public static function rolePermissions($role_id)
    {
        $permissions = Cache::get(self::$cache_prefix.$role_id);
        if(!$permissions){
            $permissions = self::find($role_id)->permissions->groupby('name')->toArray();
            Cache::put(self::$cache_prefix.$role_id, $permissions);
        }
        return $permissions;
    }

    public static function clearCache($role_id)
    {
        return Cache::forget(self::$cache_prefix.$role_id);
    }
}
