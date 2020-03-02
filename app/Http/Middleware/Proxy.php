<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class Proxy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Create a PSR-7 request object to send
        // $headers = ['Authorization' => \Auth::user()->token_expenses];
        // $request->headers->set('Authorization', \Auth::user()->token_expenses);
        // return $request;
        $response = $next($request);
        Log::debug(\Auth::guest());
        if (!\Auth::guest()) {
            Log::debug('$user66666666');
            Log::debug(session('expenses'));
            $response->headers->set('Authorization', session('expenses'));
        }
        // Perform action

        return $response;
    }
}
