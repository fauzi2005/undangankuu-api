<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->email_verified_at) {
//            auth()->logout();
//            return redirect()->route('login')
//                ->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');
//            return $request->expectsJson()
//                ? abort(403, 'Your email address is not verified.')
//                : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
            return response()->json(['Error' => 'Your email address is not verified.'], 403);
        }

        return $next($request);
    }
}
