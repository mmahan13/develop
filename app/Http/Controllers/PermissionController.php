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

class PermissionController extends Controller
{
    /**
     * @return string
     */
    public function list()
    {
        return ['permissions' => Permission::all()];
    }

    /**
     * Add new permission
     * @param Request $request
     * @return array
     */
    public function new(Request $request)
    {
        try {
            $permission
                = Permission::create(
                    [
                        'module' => $request->input('module'),
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                        'route' => $request->input('route')
                    ]
                );
            return ['permission' => $permission];
        } catch (QueryException $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Get details of user
     * @param Request $request
     * @param Int $userID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function details(Request $request, int $permissionID)
    {
        try {
            $permission = Permission::where('id', $permissionID)
                ->firstOrFail();
            return ['permissionData' => $permission];
        } catch (ModelNotFoundException $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Update Permission with data of form
     * @param Request $request
     * @param Int $userID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, int $permissionID)
    {
        try {
            $permission = Permission::findOrFail($permissionID);
            $permission->fill(
                [
                    'module' => $request->input('module'),
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'route' => $request->input('route')
                ]
            );

            $permission->save();
            return response($permission, 200);
        } catch (ModelNotFoundException $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Remove user from database
     * @param Request $request
     * @param Int $userID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, int $permissionID)
    {
        try {
            $permission = Permission::findOrFail($permissionID);
            $permission->delete();
            return response($permission, 200);
        } catch (ModelNotFoundException $exception) {
            return response($exception->getMessage(), 500);
        }
    }
}
