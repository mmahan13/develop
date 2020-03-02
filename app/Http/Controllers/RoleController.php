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

class RoleController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function list(Request $request)
    {
        $roles =  Role::where('name', '<>', 'super')
            ->with('permissions')
            ->get();
        return ['roles' => $roles];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        try {
            $role = Role::create(
                [
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                ]
            );
            $role->permissions()->sync(
                array_map(
                    function ($id) {
                        return $id['id'];
                    },
                    $request->input('permissionSelection')
                )
            );
            $role->save();
            return ['role' => $role];
        } catch (Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function details(Request $request, $roleID)
    {
        try {
            $role = Role::where('id', $roleID)
                    ->with('permissions')
                    ->firstOrFail();
            return ['roleData' => $role];
        } catch (ModelNotFoundException $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $roleID)
    {
        try {
            $role = Role::findOrFail($roleID);
            $role->fill(
                [
                    'name' => $request->input('name'),
                    'description' => $request->input('description')
                ]
            );
            $role->permissions()->sync(
                array_map(
                    function ($permission) {
                        return $permission['id'];
                    },
                    $request->input('permissionSelection')
                )
            );
            $role->save();
        } catch (ModelNotFoundException $exception) {
            return response($exception->getMessage(), 500);
        }
        return $request->all();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, $roleID)
    {
        try {
            $role = Role::findOrFail($roleID);
            $role->users()->detach();
            $role->delete();
            return response($role, 200);
        } catch (ModelNotFoundException $exception) {
            return response($exception->getMessage(), 500);
        }
    }
}
