<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class PermissionsChecker
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
        if (!Auth::guest()) {
            if ($request->path() == '/') return $next($request);
            $roles = Auth::user()->roles;
            foreach ($roles as $role) {
                // si el usuario es super no se valida
                if ($role['name'] == 'super') {
                    return $next($request);
                }
                //valida si alguno de los roles del usuario tiene permiso para la ruta dada. Se usa la ruta
                // como inicio de cadena. ej. clients accede a el resto de clients/
                if ($role->hasPermissionForUrl($request->path())) {
                    return $next($request);
                }
            }
            if ($request->ajax()) {
                return response('Ruta no permitida', 403);
            } else {
                // devuelve al home cuando no se tiene permiso para la ruta
                return Redirect::back()->withErrors(['Ruta no permitida']);
            }
        } else {
            return response()->redirectGuest('/');
        }
    }
}
