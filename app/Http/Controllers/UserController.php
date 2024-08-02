<?php

 

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::get();
    }

    public function store(Request  $request)
    {          
        $user = User::where(['email'=>$request->email])->first();    
        if(empty($user)){
            $user = User::create($request->all());
        }
        $token = $user->createToken('api_token')->plainTextToken;
        $user->api_token = $token;
        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return $user->load(['experiences', 'educations', 'skills']);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
