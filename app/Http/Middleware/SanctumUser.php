<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SanctumUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $return = array();

        if (!Auth::guard('user')->check()) {
            $return['code'] = 'E0000';
            $return['message'] = 'ユーザー認証に失敗しました。';
            return response()->json($return);
        }

        return $next($request);
    }
}
