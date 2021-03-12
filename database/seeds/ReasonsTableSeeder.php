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
            [1, 'Almoço', new \DateTime('2020-01-01 01:00:00')],
            [2, 'Daily', new \DateTime('2020-01-01 00:30:00')],
            [3, 'Banheiro', new \DateTime('2020-01-01 00:10:00')],
            [4, 'Café', new \DateTime('2020-01-01 00:10:00')],
            [5, 'Reunião'],
            [6, 'Início de Expediente'],
            [7, 'Sair Fora'],
            [8, 'Outros'],
            [9, 'Fale Comigo'],
            [10, 'Preciso de Concentração']
        ];

        foreach($values as $value) {
            DB::table('reasons')->insert([
                'id' => $value[0],
                'name' => $value[1],
                'expected_return' => $value[2] ?? null,
            ]);
        }
    }
}
