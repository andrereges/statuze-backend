<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [1, 10]
        ];

        foreach($values as $value) {
            DB::table('user_statuses')->insert([
                'user_id' => $value[0],
                'status_reason_id' => $value[1],
                'from' => date("Y-m-d H:i:s")
            ]); 
        }
    }
}