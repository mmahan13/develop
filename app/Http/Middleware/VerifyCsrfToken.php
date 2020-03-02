<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use \Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Carbon\Carbon;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addCookieToResponse($request, $response)
    {
        $config = config('session');

        $response->headers->setCookie(
            new Cookie(
                'XSRF-TOKEN_' . substr(md5(env('APP_NAME')), 0, 10),
                $request->session()->token(), Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
                $config['path'], $config['domain'], $config['secure'], false
            )
        );

        return $response;
    }
}
