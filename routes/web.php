<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Cambio de idioma
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'es', 'fr'])) {
        // 1. Guardamos en sesión
        Session::put('locale', $locale);

        // 2. Forzamos el cambio en la aplicación AHORA MISMO
        App::setLocale($locale);
    }
    return back();
})->name('lang.switch');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

// CRUD Protegido
Route::middleware('auth')->group(function () {
    Route::resource('students', \App\Http\Controllers\StudentController::class);
    // Ruta simple para proyectos (solo lectura para cumplir requisito)
    Route::resource('projects', ProjectController::class);
});
require __DIR__.'/auth.php';
