<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class FirstLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if(is_null($user->created_at))
        {
            return redirect()->route('reset_password');
        }
        return $next($request);
        // $user = User::where('email', $request->email)->first();
        // if(is_null($user->created_at))
        // {
        //     return redirect()->
        // }
    }
}
