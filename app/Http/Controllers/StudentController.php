<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // 1. Lógica de Filtrado (Buscador)
        $query = Student::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        return Inertia::render('Students/Index', [
            // Mantenemos los parámetros de búsqueda en la paginación con "withQueryString"
            'students' => $query->orderBy('id', 'desc')->paginate(5)->withQueryString(),
            'filters' => $request->only(['search']) // Pasamos el texto buscado a Vue
        ]);
    }

    public function store(Request $request)
    {
        // 2. Proteger la ruta: Si NO es admin, le da error 403 (Prohibido)
        abort_if(!$request->user()->isAdmin(), 403, 'No tienes permiso para hacer esto.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
        ]);

        Student::create($validated);
        return redirect()->back()->with('message', 'student_created');
    }

    public function update(Request $request, Student $student)
    {
        abort_if(!$request->user()->isAdmin(), 403); // Proteger
        // ... (resto de tu código update)
    }

    public function destroy(Request $request, Student $student)
    {
        abort_if(!$request->user()->isAdmin(), 403); // Proteger
        $student->delete();
        return redirect()->back()->with('message', 'student_deleted');
    }
}
