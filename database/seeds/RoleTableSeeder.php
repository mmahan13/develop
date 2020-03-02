<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=Role::create([
            'name' => 'super',
            'description' => 'Todos los permisos',
        ]);
        $role->save();

        $role=Role::create([
            'name' => 'admin',
            'description' => 'Administración',
            'id_department' => 'EF44BDEC-E186-4E5D-9547-5C8864EF2502',
        ]);
        $role->save();

        $role=Role::create([
            'name' => 'user',
            'description' => 'Usuario Base',
            'id_department' => 'BFA0FF74-CD3C-4C5F-8AEE-8AFEC8C2A81E',
        ]);
        $role->save();
    }
}
