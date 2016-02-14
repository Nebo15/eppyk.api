<?php

use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::truncate();
        \App\Models\User::create([
            'login' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
        \App\Models\User::create([
            'login' => 'manager',
            'password' => Hash::make('manager'),
            'role' => 'manager',
        ]);
    }
}
