<?php

namespace Database\Seeders;

use App\Models\Aluno;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AlunoSeeder extends Seeder
{
    public function run()
    {
        $turmaADS2023 = \App\Models\Turma::where('ano', 2023)
            ->whereHas('curso', function($q) {
                $q->where('sigla', 'ADS');
            })->first();

        $turmaINFO2023 = \App\Models\Turma::where('ano', 2023)
            ->whereHas('curso', function($q) {
                $q->where('sigla', 'INFO');
            })->first();

        $professorADS = \App\Models\User::create([
            'nome' => 'Professor ADS',
            'email' => 'prof.ads@example.com',
            'senha' => Hash::make('password'),
            'role_id' => 2,
        ]);

        $alunos = [
            [
                'nome' => 'Beatriz Yoshimi',
                'cpf' => '12345678901',
                'email' => 'yoshimi@aluno.example.com',
                'senha' => Hash::make('aluno123'),
                'user_id' => $professorADS->id,
                'curso_id' => $turmaADS2023->curso_id,
                'turma_id' => $turmaADS2023->id,
            ],
            [
                'nome' => 'Heloisa Abrantes',
                'cpf' => '98765432109',
                'email' => 'heloisa@aluno.example.com',
                'senha' => Hash::make('aluno123'),
                'user_id' => $professorADS->id,
                'curso_id' => $turmaINFO2023->curso_id,
                'turma_id' => $turmaINFO2023->id,
            ],
        ];

        foreach ($alunos as $aluno) {
            Aluno::create($aluno);
            $this->command->info("Aluno {$aluno['nome']} criado!");
        }
    }
}