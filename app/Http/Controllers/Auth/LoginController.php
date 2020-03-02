<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Elegir el nombre del campo segun el tipo de datos de en el input (login por defecto) lo he cambiado a social_name
        $field = filter_var(
            $request->input('email'),
            FILTER_VALIDATE_EMAIL
        ) ? 'email' : 'dni';
        // Guardar las credenciales en el request
        // $request->merge([$field => $request->input('email')]);
        // parte del default para sacar los usuarios con muchos intentos
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        // intento de login personalizado
        if ($this->guard('admin')->attempt($request->only($field, 'password'), $request->filled('remember'))
        ) {
            \Auth::user()->expenses = '';
            if ($this->guard()->user()->logged == 0) {
                $token = $this->guard()->user()->getRememberToken();
                $this->guard()->user()->save();
                $email = $this->guard()->user()->email;
                $this->guard()->logout();
                return view('auth.passwords.first_login')->with(
                    ['token' => $token, 'email' => $email]
                );
            }

            return $this->sendLoginResponse($request);
        }
        // Ha fracasado el login se sigue con algoritmo por defecto
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
}
