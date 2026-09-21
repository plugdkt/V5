<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsEditor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isEditor()) {
            return redirect()->route('home')->with('error', 'คุณไม่มีสิทธิ์ในการเข้าถึงหน้าควบคุมระบบ (CMS)');
        }

        return $next($request);
    }
}
