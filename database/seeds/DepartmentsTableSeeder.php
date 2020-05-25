<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            'Administrativo',
            'Comercial',
            'Diretoria',
            'Desenvolvimento',
            'Especialista',
            'Qualidade',
            'Infra/Suporte',
            'Marketing',
            'Projeto'
        ];

        foreach($values as $value) {
            DB::table('departments')->insert([
                'name' => $value
            ]);
        }
    }
}
