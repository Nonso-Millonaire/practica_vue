<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Solo admins pueden ver esto
        abort_if(!$request->user()->isAdmin(), 403, 'Acceso denegado');

        return Inertia::render('Users/Index', [
            'users' => User::orderBy('id', 'desc')->paginate(10)
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        abort_if(!$request->user()->isAdmin(), 403);

        // Evitar que el admin se quite el rol a sí mismo por error
        if ($request->user()->id === $user->id) {
            return redirect()->back()->with('error', 'cannot_change_own_role');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->back()->with('message', 'role_updated');
    }
}
