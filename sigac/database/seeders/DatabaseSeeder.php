<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            NivelSeeder::class,
            EixoSeeder::class,
            CursoSeeder::class,
            TurmaSeeder::class,
            CategoriaSeeder::class,
            AlunoSeeder::class,
            ComprovanteSeeder::class,
            DocumentoSeeder::class,
            DeclaracaoSeeder::class,
        ]);
    }
}