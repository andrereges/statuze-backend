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
            ['Disponível', 'bg-green'],
            ['Ocupado', 'bg-red'],
            ['Ausente', 'bg-yellow'],
            ['Deslogado', 'bg-grey']
        ];

        foreach($values as $value) {
            DB::table('statuses')->insert([
                'name' => $value[0],
                'color' => $value[1]
            ]); 
        }
    }
}