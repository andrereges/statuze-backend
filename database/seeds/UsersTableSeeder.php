<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'birth' => date("2020-01-01 00:00:00"),
            'email' => 'admin@statuze.com.br',
            'password' => Hash::make('admin'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'work_schedule_id' => 3, 
            'department_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]); 
    }
}