<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $adminPassword = env('ADMIN_PASSWORD', 'valtwise@123');

        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
