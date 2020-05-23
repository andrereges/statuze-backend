<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [1, 6],
            [1, 9],
            [2, 2],
            [2, 5],
            [2, 8],
            [2, 10],
            [3, 1],
            [3, 3],
            [3, 4],
            [3, 8],
            [4, 7],
            [4, 8]
        ];

        foreach($values as $value) {
            DB::table('status_reasons')->insert([
                'status_id' => $value[0],
                'reason_id' => $value[1]
            ]);
        }
    }
}
