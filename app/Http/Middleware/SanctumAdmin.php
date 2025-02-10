<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SanctumAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $return = array();

        if (!Auth::guard('admin')->check()) {
            $return['code'] = 'E0000';
            $return['message'] = '管理者認証に失敗しました。';
            return response()->json($return);
        }

        return $next($request);
    }
}
