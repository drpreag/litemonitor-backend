<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\PermissionCollection;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderby('id')->get();
        return new RoleCollection($roles);
    }

    /**
     * Store a newly created resource in storage or update old one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('put')) {    // put update
            $role = Role::findOrFail($request->id);
            $role->exists = true;
        } else { // post, new one
            $role = new Role;
        }
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return new RoleResource($role);
    }

    /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $role->exists = true;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->delete()) {
            return new RoleResource($role);
        } else {
            return false;
        }
    }

    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permissions($id)
    {
        $role_id = intval($id);
        $permissions = Permission::where('role_id', $role_id)->orderby('role_id')->get();
        return new PermissionCollection($permissions);
    }
}

