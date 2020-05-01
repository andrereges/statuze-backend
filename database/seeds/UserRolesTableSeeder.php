<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [1, 1],
            [1, 2],
            [1, 3]
        ];

        foreach($values as $value) {
            DB::table('user_roles')->insert([
                'user_id' => $value[0],
                'role_id' => $value[1]
            ]); 
        }
    }
}