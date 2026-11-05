<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if ($request->user()->role !== $role) {
            if ($request->user()->role === 'penyelenggara') {
                return redirect()->route('organizer.dashboard');
            }

            return redirect()->route('peserta.dashboard');
        }

        return $next($request);
    }
}
