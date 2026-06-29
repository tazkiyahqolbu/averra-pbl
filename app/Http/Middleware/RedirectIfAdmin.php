<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user instanceof User && $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Halaman ini hanya untuk pelanggan. Anda diarahkan ke panel admin.');
        }

        return $next($request);
    }
}
