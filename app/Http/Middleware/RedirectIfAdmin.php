<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Halaman ini hanya untuk pelanggan. Anda diarahkan ke panel admin.');
        }

        return $next($request);
    }
}
