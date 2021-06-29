# Laravel Role Permission
![Packagist Version](https://img.shields.io/packagist/v/abdul/laravel-role-permission)
![Packagist License](https://img.shields.io/packagist/l/abdul/laravel-role-permission)
![Packagist Downloads](https://img.shields.io/packagist/dt/abdul/laravel-role-permission)

An easy and flexible Laravel roles and permissions management for admin.

This package basic idea is based on [(amiryousefi/laravel-permission)](https://github.com/amiryousefi/laravel-permission) module.

## Why we need a Laravel permission package
In many projects, we need to implement a role-based permissions management system for our clients. This will make the development and controlling the access management easy for web projects built on Laravel.
### How add permissions via admin panel

After installation if you visit the route
[Roles From](http://127.0.0.1:8000/config/role/create) All routes belongs to `auth.role` middleware will appear, you can add to role according to your application needs

![role form](role-form.jpg?raw=true)

## How to use
The idea is to use this package as easy and as flexible as possible.


This package creates a list of all your routes and assigns these permissions list to user roles.

Although the `laravel-role-permission` package does most of the work, you could easily extend it and implement your authorization system.


### Installation
Start with installing the package through the composer. Run this command in your terminal:
```
$ composer require abdul/laravel-role-permission
```

After that, you need to run the migration files:
```
$ php artisan migrate
```

### How to authorize user
This package adds a `role_id` to the `users` table.
Roles are stored in the `roles` table. You can assign the permission to roles in your administrator panel, assign the role to user and Then, you only need to assign `auth.role` middleware to your routes.

### Assign a route to a role
Besides middleware and other route settings, you can use a `role` key in your route groups to assign a role to your routes. 


You can put your routes for a role in a `Route` group like this:
```php
Route::group([
    'middleware' => 'auth.role',
    'prefix' => 'config',
    'module' => 'Role',
    'role' => 'admin',
    ...
],function (){
    Route::get('/roles', 'RoleController@index');
});
```
Of course, you can have as many as route groups like this.


Then you need to run this artisan command to register all permissions:
```
$ php artisan permissions:generate 
```
This command will register all permissions and assign permissions to the roles.

If you add a `fresh` option to this command, it will delete all data and generate fresh routes data:
```
$ php artisan permissions:generate --fresh
```

Now only users with the proper role can access the route assigned to them.

Don't forget that this package does not handle assigning roles to the users. You need to handle this in your administration panel or anywhere else you handle your users.


### How to create roles
The `php artisan permissions:generate` command will make all roles defined in the routes if they are not exist.

Also, You can create a seeder to fill the `roles` table. It takes only a `name` field.

Your `RolesSeeser` file can look like this.
```php
Role::firstOrCreate(['name' => 'admin']);
Role::firstOrCreate(['name' => 'customer']);
```
Don't forget to import the `Role` model in your seeder.
```php
use Abdul\RolePermission\Models\Role;
```

### How to clear permissions
To clear registered permissions you can run this command:
```
$ php artisan permissions:clear
```

You can use this command to clear all permissions data for a specific role
```
$ php artisan permissions:clear --roles role1 role2
```

To erase only permissions list, run `permissions:clear` command with this option:
```
$ php artisan permissions:clear --tables permissions
```

To clear all roles:
```
$ php artisan permissions:clear --tables roles
```

To clear only permissions role relation:
```
$ php artisan permissions:clear --tables permission_role
```
This command erases all permissions assigned to roles, so you can regenerate permissions

Also, you can use these options in combination:
```
$ php artisan permissions:clear --roles admin --tables permission_role
```
