<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        //Manera normal
        //return response()->json(['data' => $users, 200]);
        //Manera ahorrando código;
        return $this->showAll($users);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validación de los parámetros
        $data = $request->validate([
            'name' => 'required:max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',

        ]);
        //Encriptando password
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

//        return response()->json(['data' => $user], 201);
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
//        return response()->json(['data' => $user, 200]);
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'max:255',
            'email' => '|email|unique:users,email,' . $user->id,
            'password' => '|min:6|confirmed',
        ]);

        if($request->has('name')){
            $user->name = $request->name;
            $user->name = $request->name;
        }

        if($request->has('email')){
            $user->email = $request->email;
        }

        if($request->has('password')){
            $user->password = bcrypt($request ->password);
        }

        if(!$user->isDirty()){
//            return response()->json(['error' => ['code' => 400, 'message' => 'Please specify at least one different value']], 422);
            return $this->errorResponse('Please specify at least one different value',422);
        }

        $user->save();

//        return response()->json(['data' => $user, 200]);
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = $user->delete();

//        return response()->json(['data' => $user], 200);
        return $this->showOne($user);
    }
}
