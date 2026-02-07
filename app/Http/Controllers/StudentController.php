<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Student;

class StudentController extends Controller
{
    public function index() {
        return Inertia::render('Students/Index', [
            'students' => Student::orderBy('id', 'desc')->paginate(5) // Paginación [cite: 42]
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
        ]);
        Student::create($validated);
        return redirect()->back()->with('success', 'success_created'); // Usamos clave de traducción
    }

    public function update(Request $request, Student $student) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,'.$student->id,
        ]);
        $student->update($validated);
        return redirect()->back()->with('success', 'success_updated');
    }

    public function destroy(Student $student) {
        $student->delete();
        return redirect()->back()->with('success', 'success_deleted');
    }
}
