<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        //$page = intval ($request->input('page', 1));
        //$per_page = intval ($request->input('per_page', 15));
        //$users = User::paginate($per_page, ['*'], 'page', $page);
        
        $users = User::all();
        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage, POST request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            array(
                'name'          => 'required|max:255',
                'email'         => 'required|min:5|max:255|unique:users,email',
                'role_id'       => 'required|integer|min:0|max:9',
                'active'        => 'required|integer|min:0|max:1',
                'password'      => 'required|min:6|max:32',
            )
        );

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->active = $request->active;
        $user->password = $request->password;

        $user->save();

        return new UserResource($user);
    }

    /**
     * Store updated record, PUT request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate(
            $request,
            array(
                'id'            => 'required|integer',
                'name'          => 'required|max:255',
                'email'         => 'required|min:5|max:255|unique:users,email,'.$request->id,
                'role_id'       => 'required|integer|min:0|max:9',
                'active'        => 'required|integer|min:0|max:1',
                'password'      => 'nullable'
            )
        );

        $user = User::findOrFail($request->id);
        $user->exists = true;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->active = $request->active;// ? true : false;
          
        $user->save();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ?\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        if ($user!=null)
            return new UserResource($user);
        else
            return Response::json(['error' => 'Resource not found' ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return ?\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return new UserResource($user);
        } else {
            return Response::json(['error' => 'Resource not found' ], 404);
        }
    }
}
