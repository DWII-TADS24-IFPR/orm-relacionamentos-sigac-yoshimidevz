<?php

namespace Database\Seeders;

use App\Models\Nivel;
use Illuminate\Database\Seeder;

class NivelSeeder extends Seeder
{
    public function run()
    {
        $niveis = [
            ['nome' => 'Técnico'],
            ['nome' => 'Graduação'],
            ['nome' => 'Pós-Graduação'],
            ['nome' => 'Extensão'],
        ];

        foreach ($niveis as $nivel) {
            Nivel::create($nivel);
            $this->command->info("Nível {$nivel['nome']} criado com sucesso!");
        }
    }
}