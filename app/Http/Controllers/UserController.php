<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(['message' => 'ciao'], 200);
        //return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $fields = $request->validate([
        //     'email' => 'required|string|unique:users,email',
        //     'password' => 'required|string|confirmed'
        // ]);

        // $user = User::create([
        //     'email' => $fields['name'],
        //     'password' => bcrypt($fields['password'])
        // ]);

        // $token = $user->createToken('myapptoken')->plainTextToken;

        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];
            $response = [ 'user' => $request -> email];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
