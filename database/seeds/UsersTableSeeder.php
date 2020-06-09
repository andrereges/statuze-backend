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
            'email' => 'admin@statuze.com.br',
            'cellphone' => null,
            'active' => true,
            'gender' => 'Masculino',
            'birth' => date("2020-01-01 00:00:00"),
            'password' => Hash::make('5t4tuz3@statuze.com.br'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'work_schedule_id' => 3,
            'department_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
