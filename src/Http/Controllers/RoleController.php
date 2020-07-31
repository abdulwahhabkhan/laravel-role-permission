<?php

namespace Abdul\RolePermission\Http\Controllers;

use Abdul\RolePermission\Models\Permission;
use Abdul\RolePermission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('rolepermission::roles.index', ['roles'=> $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $urls = Permission::all()->groupBy(['section', 'module'], $preserveKeys = true);
        $role = new Role();

        return view("rolepermission::roles.form", [
            'heading' => 'Add Role',
            'role' => $role,
            'role_permissions' => $role->permissions->pluck('id')->toArray(),
            'method' => 'post',
            'action' => route('role.store'),
            'urls' => $urls
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:150',
            'description' => 'max:255',
        ]);

        $role = new Role();
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->save();

        $permissions = $request->get('permissions', []);
        $role->permissions()->detach();
        foreach ($permissions as $link){
            $role->permissions()->attach($link);
        }

        return redirect(route('role.index'))->with('success', "Data saved successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $urls = Permission::all()->groupBy(['section', 'module'], $preserveKeys = true);
        $role = Role::find($id);
        return view("rolepermission::roles.form", [
            'heading'=>'Edit Role',
            'role' => $role,
            'role_permissions' => $role->permissions->pluck('id')->toArray(),
            'method' => 'put',
            'action' => route('role.update', $id),
            'urls' => $urls
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:150',
            'description' => 'max:255',
        ]);

        $role =Role::find($id);
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->save();
        $permissions = $request->get('permissions', []);
        $role->permissions()->detach();
        foreach ($permissions as $link){
            $role->permissions()->attach($link);
        }
        return redirect(route('role.index'))->with('success', "Data saved successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
