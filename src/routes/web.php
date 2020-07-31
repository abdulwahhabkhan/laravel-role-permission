<?php

use Illuminate\Support\Facades\Route;
use Abdul\RolePermission\Http\Controllers\RoleController;

Route::group(['prefix'=>'config', 'module'=>'Role', 'role'=>'admin', 'middleware'=> ['web','auth', 'auth.role']], function(){
    Route::resource('role', RoleController::class);
});


