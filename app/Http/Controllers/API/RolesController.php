<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleCollection;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$page = intval ($request->input('page', 1));
        //$per_page = intval ($request->input('per_page', 15));
        //$roles = Role::paginate($per_page, ['*'], 'page', $page);

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
}
