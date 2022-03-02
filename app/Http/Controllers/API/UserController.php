<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(User::class, 'users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $user= User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);


        if ($request->has('role')) {
            $user->assignRole($request->role['name']);
        }

        if ($request->has('permissions')) {
            $user->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
        }

        return response(['message'=>'User Created', 'user'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user->with('roles')->with('permissions')->with('articles');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
        ]);

        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
        ]);

        if ($request->has('role')) {
            $user->syncRoles($request->role['name']);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions(collect($request->permissions)->pluck('id')->toArray());
        }

        return response(['message'=>'User Updated', 'user'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return User::destroy($user->id);
    }
}
