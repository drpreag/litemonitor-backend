<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PermissionCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;

class PermissionsController extends Controller
{
    public function Permission ()
    {
        $usersRole = auth('api')->user()->role_id;
        $permission = Permission::
            where('object', "Users")->
            where('role_id', $usersRole)->
            first();
            return ($permission);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->Permission()->b)
            return \Response::json(['error' => 'Not nought privileges' ], 401);

        $permissions = this::where('role_id', $request->user()->role_id)->get();
        return new PermissionCollection($permissions);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_roles(Request $request)
    {
        if (!$this->Permission()->b)
            return \Response::json(['error' => 'Not nought privileges' ], 401);

        $permissions = this::where('role_id', $request->user()->role_id)->get();
        return new PermissionCollection($permissions);
    }

}
