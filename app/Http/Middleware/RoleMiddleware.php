<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Mohon maaf, kamu harus login terlebih dahulu.');
        }

        $user = Auth::user();
        $rolesArray = explode('|', $roles);

        if (!in_array($user->role, $rolesArray)) {
            return redirect()->back()->with('error', 'Mohon maaf, kamu tidak memiliki akses untuk melihat halaman atau fitur tersebut.');
        }

        return $next($request);
    }
}
