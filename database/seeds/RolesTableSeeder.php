<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            'ADMIN',
            'MANAGER',
            'USER'
        ];

        foreach($values as $value) {
            DB::table('roles')->insert([
                'name' => $value
            ]); 
        }
    }
}