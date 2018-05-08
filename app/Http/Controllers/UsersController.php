<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = intval ($request->input('page', 1));
        $per_page = intval ($request->input('per_page', 15));

        $users = User::paginate($per_page, ['*'], 'page', $page);
        return new UserCollection($users);
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
            $user = User::findOrFail($request->id);
            $user->exists = true;
        }
        else { // post, new one
            $user = new User;      
            $user->email = $request->email;        
            if ($request->has('password')) 
                $user->password = $request->password;
        }
        $user->name = $request->name;
        if ($request->has('active'))
            $user->active = $request->active ? true : false; // 1 : 0
        if ($request->has('role_id'))
            $user->role_id = $request->role_id;
        $user->save();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail ($id);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail ($id);

        if ($user->delete())
            return new UserResource($user);
        else
            return false;
    }
}
