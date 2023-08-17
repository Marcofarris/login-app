<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MidAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user(); // Get the currently authenticated user...

        $users_roles = DB::table('users')
        ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
        ->join('roles', 'roles.id', '=', 'user_roles.role_id')
        ->select('roles.role_name')
        ->where('users.id', $user->id)
        ->first();
         
        if($users_roles->role_name == "Admin"){ // diverso per prova
    return $next($request);
    } 

    return response()->json('Non autorizzato');
    
    }
}
