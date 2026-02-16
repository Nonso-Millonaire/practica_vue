<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::latest()->get() // Trae los últimos primero
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validamos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // 2. Creamos
        Project::create($validated);

        // 3. Redirigimos con mensaje TRADUCIDO
        // Usamos la clave 'project_created' que pondremos en el JSON
        return redirect()->back()->with('message', 'project_created');
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $project->update($validated);

        return redirect()->back()->with('message', 'project_updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('message', 'project_deleted');
    }
}
