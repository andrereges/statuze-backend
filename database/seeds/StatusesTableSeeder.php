<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [1, 'Disponível', 'bg-green'],
            [2, 'Ocupado', 'bg-red'],
            [3, 'Ausente', 'bg-yellow'],
            [4, 'Deslogado', 'bg-grey']
        ];

        foreach($values as $value) {
            DB::table('statuses')->insert([
                'id' => $value[0],
                'name' => $value[1],
                'color' => $value[2]
            ]); 
        }
    }
}