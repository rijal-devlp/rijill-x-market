<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login, arahkan ke halaman login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Hanya customer yang boleh mengakses route customer
        if ($request->user()->role !== 'customer') {
            abort(
                403,
                'Halaman ini hanya dapat diakses oleh customer.'
            );
        }

        return $next($request);
    }
}