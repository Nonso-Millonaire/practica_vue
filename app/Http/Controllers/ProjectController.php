<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Muestra la lista de proyectos con opción de búsqueda.
     */
    public function index(Request $request)
    {
        // 1. Iniciamos la consulta
        $query = Project::query();

        // 2. Lógica de Filtrado (Buscador)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // 3. Devolvemos la vista con los proyectos paginados y los filtros
        return Inertia::render('Projects/Index', [
            'projects' => $query->orderBy('id', 'desc')->paginate(6)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Guarda un nuevo proyecto (Solo Admin).
     */
    public function store(Request $request)
    {
        // Proteger: Si NO es admin, da error 403
        abort_if(!$request->user()->isAdmin(), 403, 'No tienes permiso para hacer esto.');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Project::create($validated);

        return redirect()->back()->with('message', 'project_created');
    }

    /**
     * Actualiza un proyecto existente (Solo Admin).
     */
    public function update(Request $request, Project $project)
    {
        // Proteger: Si NO es admin, da error 403
        abort_if(!$request->user()->isAdmin(), 403, 'No tienes permiso para hacer esto.');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $project->update($validated);

        return redirect()->back()->with('message', 'project_updated');
    }

    /**
     * Elimina un proyecto (Solo Admin).
     */
    public function destroy(Request $request, Project $project)
    {
        // Proteger: Si NO es admin, da error 403
        abort_if(!$request->user()->isAdmin(), 403, 'No tienes permiso para hacer esto.');

        $project->delete();

        return redirect()->back()->with('message', 'project_deleted');
    }
}
