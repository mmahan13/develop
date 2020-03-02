<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'acceso a módulo',
            'description' => 'Administración de usuarios',
            'module' => 'user_admin',
            'route' => 'users'
        ])->roles()->attach(1);
        Permission::create([
            'name' => 'acceso a módulo',
            'description' => 'Carpetas',
            'module' => 'file_main',
            'route' => 'file'
        ])->roles()->attach([1, 2, 3]);
        Permission::create([
            'name' => 'consulta',
            'description' => 'Operaciones de listado',
            'module' => 'user_list',
            'route' => 'list'
        ])->roles()->attach([1, 2]);
        Permission::create([
            'name' => 'consulta por id',
            'description' => 'Operaciones de consulta por id',
            'module' => 'user_by_id',
            'route' => 'get'
        ])->roles()->attach([1, 2]);
        Permission::create([
            'name' => 'actualizar',
            'description' => 'Operaciones de actualizar',
            'module' => 'user_update',
            'route' => 'update'
        ])->roles()->attach([1, 2]);
        Permission::create([
            'name' => 'agregar',
            'description' => 'Operaciones de agregado',
            'module' => 'user_add',
            'route' => 'add'
        ])->roles()->attach([1, 2]);
        Permission::create([
            'name' => 'borrar',
            'description' => 'Operaciones de borrado',
            'module' => 'user_delete',
            'route' => 'delete'
        ])->roles()->attach([1, 2]);
    }
}
