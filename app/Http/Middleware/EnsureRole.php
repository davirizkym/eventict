<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowedRoles = [];
        foreach ($roles as $r) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $r));
        }
        $allowedRoles = array_map('trim', $allowedRoles);

        $userRole = $request->user()->role;

        $hasAccess = in_array($userRole, $allowedRoles, true)
            || (in_array('penyelenggara', $allowedRoles, true) && in_array($userRole, ['administrator', 'admin'], true));

        if (! $hasAccess) {
            if (in_array($userRole, ['penyelenggara', 'administrator', 'admin'], true)) {
                return redirect()->route('organizer.dashboard');
            }

            return redirect()->route('peserta.dashboard');
        }

        return $next($request);
    }
}
