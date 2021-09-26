<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthBasic
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            Auth::onceBasic();
            return $next($request);
        } catch (\Throwable $throwable) {
            return response()->json(['status' => Response::HTTP_UNAUTHORIZED, 'message' => 'Unauthorized']);
        }
    }
}
