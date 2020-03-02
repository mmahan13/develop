<?php

namespace App\Http\Controllers;

use App\Client;
use App\Company;
use App\Conexion;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class UserController extends Controller
{
    /**
     * Returned view of users
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('users.user');
    }

    /**
     * Get all user from database
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $users = User::where('id', '>', 1)
            ->with('roles')
            ->get(['name', 'email', 'dni', 'id']);
        return ['users' => $users];
    }

    /**
     * Get details of user
     * @param Request $request
     * @param Int $userID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function details(Request $request, int $userID)
    {
        if ($userID != 1) {
            try {
                $user = User::where('id', $userID)
                    ->with('roles')
                    ->firstOrFail();
                return ['userData' => $user];
            } catch (ModelNotFoundException $exception) {
                return response($exception->getMessage(), 500);
            }
        }
        return response('No se ha encontrado', 500);
    }

    /**
     * @param Request $request
     * @param $dni
     * @return bool
     */
    public function existsNif(Request $request, $dni)
    {
        return response()->json(['exists' => User::where('dni', $dni)->count() > 0]);
    }

    /**
     * @param Request $request
     * @param $email
     * @return bool
     */
    public function existsEmail(Request $request, $email)
    {
        return
            response()->json(['exists' => User::where('email', $email)->count() > 0]);
    }

    /**
     * Add new user
     * @param Request $request
     * @return array
     */
    public function new(Request $request)
    {
        try {
            $user = User::create(
                [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'dni' => $request->input('dni'),
                    'password' =>
                        Hash::make($request->input('password')),
                ]
            );
            $user->roles()->sync(
                array_map(
                    function ($role) {
                        return $role['id'];
                    },
                    $request->input('selectedRoles')
                )
            );
            return response($user, 200);
        } catch (QueryException $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Remove user from database
     * @param Request $request
     * @param Int $userID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, int $userID)
    {
        try {
            $user = User::findOrFail($userID);
            $user->roles()->detach();
            $user->delete();
            return response($user, 200);
        } catch (ModelNotFoundException $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Update User with data of form
     * @param Request $request
     * @param Int $userID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, int $userID)
    {
        try {
            $user = User::findOrFail($userID);
            $user->fill(
                [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'dni' => $request->input('dni')
                ]
            );
            if ($request->input('password') !== 'null') {
                $user->password
                    = Hash::make($request->input('password'));
            }
            $user->roles()->sync(
                array_map(
                    function ($role) {
                        return $role['id'];
                    },
                    $request->input('roles')
                )
            );
            $user->save();
            return response($user, 200);
        } catch (ModelNotFoundException $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Changed user
     * 
     * @param.Request....$request...Data of user.
     * 
     * @return Response.34242342
     */
    public function switchClient(Request $request)
    {
        try {
            session()->set('current_client_id', $request->input('id')['id']);
            return response('cambiado ' . session('current_client_id'), 200);
        } catch (Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Checjk if user is her first login
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function firstLogin(Request $request)
    {
        $user = User::where('email', $request->input('email'))->firstOrFail();
        $user->password = Hash::make($request->input('password'));
        $user->logged = true;
        $user->save();
        Auth::loginUsingId($user->id);
        return redirect('/file');
    }

    public function getDatoFacturacion($num_cli)
    {
        $dato_user = User::where('id', $num_cli)->firstOrFail();
        return $dato_user['tipos_facturacion'];
        
    }


}
