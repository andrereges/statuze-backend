<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [
                'Almoço', 
                new \DateTime('2020-01-01 01:00:00')
            ],
            [
                'Daily', 
                new \DateTime('2020-01-01 00:15:00')
            ],
            [
                'Banheiro', 
                new \DateTime('2020-01-01 00:10:00')
            ],
            [
                'Caf-é', 
                new \DateTime('2020-01-01 00:10:00')
            ],
            [
                'Reunião'
            ],
            [
                'Início de Expediente'
            ],
            [
                'Final de Expediente'
            ],
            [
                'Outros'
            ],
            [
                'Fale Comigo'
            ]
        ];

        foreach($values as $value) {
            DB::table('reasons')->insert([
                'name' => $value[0],
                'expected_return' => $value[1] ?? null,
            ]); 
        }
    }
}