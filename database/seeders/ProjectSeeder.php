<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        \App\Models\Project::create([
            'title' => 'Gestión Laravel',
            'description' => 'Aplicación completa de práctica'
        ]);
        \App\Models\Project::create([
            'title' => 'Web Corporativa',
            'description' => 'Landing page con Vue'
        ]);
    }
}
