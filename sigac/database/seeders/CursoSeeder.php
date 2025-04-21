<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run()
    {
        $eixoTecnologia = \App\Models\Eixo::where('nome', 'Tecnologia')->first()->id;
        $eixoGestao = \App\Models\Eixo::where('nome', 'Gestão')->first()->id;

        $nivelTecnico = \App\Models\Nivel::where('nome', 'Técnico')->first()->id;
        $nivelGraduacao = \App\Models\Nivel::where('nome', 'Graduação')->first()->id;

        $cursos = [
            [
                'nome' => 'Análise e Desenvolvimento de Sistemas',
                'sigla' => 'ADS',
                'total_horas' => 2000,
                'nivel_id' => $nivelGraduacao,
                'eixo_id' => $eixoTecnologia,
            ],
            [
                'nome' => 'Técnico em Informática',
                'sigla' => 'INFO',
                'total_horas' => 1200,
                'nivel_id' => $nivelTecnico,
                'eixo_id' => $eixoTecnologia,
            ],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
            $this->command->info("Curso {$curso['nome']} criado!");
        }
    }
}
