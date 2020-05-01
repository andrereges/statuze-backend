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
            'Financeiro',
            'Infraestrutura',
            'Marketing',
            'Projeto',
            'Qualidade'
        ];

        foreach($values as $value) {
            DB::table('departments')->insert([
                'name' => $value
            ]); 
        }
    }
}