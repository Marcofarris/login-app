<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \Datetime;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return "ciao";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        
        //Sono insicuro sull'ordine
        $role_id = DB::table('roles')->select('id')->where('role_name', $request->input('role'))->first();

        $user_role = UserRole::create([
            'user_id' => $user->id,
            'role_id' => $role_id -> id
        ]);

        // Altro modo per fare l'insert
        // DB::table('user_roles')->insert(
        //     ['user_id' => $user -> {'id'}, 'role_id' => $role_id]
        // );

        $response = [
            'user' => $user,
            'token' => $token,
            'user_role' => $request->input('role')
        ];
        return response($response, 201);
    }


    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        // Restituire il ruolo
        
        $users_roles = DB::table('users')
        ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
        ->join('roles', 'roles.id', '=', 'user_roles.role_id')
        ->select('roles.role_name')
        ->where('users.id', $user->id)
        ->first();


        $response = [
            'user' => $user,
            'token' => $token,
            'role' => $users_roles->role_name
        ];
        return response($response, 201);
    }

    //Logout
    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }


    // Funzione che prende in entrata id user e restituisce id role
    public function getRole(Request $request)
    {
        $response = [
            
        ];
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
