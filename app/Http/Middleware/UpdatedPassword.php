<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UpdatedPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!session('default_password')) {
        //     return $next($request);
        // }

        $user = Auth::user();

        if ($user && Hash::check('password', $user->password)) {
            return redirect()->route('change-password');
        }
        return $next($request);

        // abort(403);
    }
}
