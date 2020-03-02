<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Admin',
                'dni' => '333444555',
                'email' => 'root@nscontrol.es',
                'password' => Hash::make('root'),
                'logged' => true
            ]
        )->roles()->attach(1);


        User::create(
            [
                'name' => 'Fernando',
                'dni' => '111222333',
                'email' => 'fernando.iglesias@nscontrol.es',
                'password' => Hash::make('Root777'),
                'logged' => true
            ]
        )->roles()->attach(1);

        User::create(
            [
                'name' => 'dummy',
                'dni' => '666777888',
                'email' => 'dummy@nscontrol.es',
                'password' => Hash::make('dummy')
            ]
        )->roles()->attach(3);

    }
}
