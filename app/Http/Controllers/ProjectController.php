<?php

namespace App\Http\Controllers;

use App\Models\Project; // <--- Importante: Importamos el Modelo
use Illuminate\Http\Request;
use Inertia\Inertia;    // <--- Importante: Importamos Inertia

class ProjectController extends Controller
{
    /**
     * Muestra la lista de proyectos.
     */
    public function index()
    {
        // Obtenemos todos los proyectos creados (vía Seeder o manualmente)
        $projects = Project::all();

        // Renderizamos la vista 'Projects/Index' enviando los datos
        return Inertia::render('Projects/Index', [
            'projects' => $projects
        ]);
    }
}
