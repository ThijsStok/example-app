<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            \Log::info('User is authenticated');
            \Log::info('User data: ' . json_encode(auth()->user()));

            if (auth()->user()->role === 'admin') {
                return $next($request);
            }
        }

        \Log::info('User is not authorized to access this page');
        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}