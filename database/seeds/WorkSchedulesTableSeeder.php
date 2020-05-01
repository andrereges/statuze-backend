<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkSchedulesTableSeeder extends Seeder
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
                'Horário 01',
                new \DateTime('2020-01-01 08:00:00'),
                new \DateTime('2020-01-01 17:00:00')
            ],
            [
                'Horário 02', 
                new \DateTime('2020-01-01 09:00:00'),
                new \DateTime('2020-01-01 18:00:00')
            ],
            [
                'Horário 03', 
                new \DateTime('2020-01-01 10:00:00'),
                new \DateTime('2020-01-01 19:00:00')
            ],
        ];

        foreach($values as $value) {
            DB::table('work_schedules')->insert([
                'name' => $value[0],
                'begin' => $value[1],
                'end' => $value[2],
            ]); 
        }
    }
}