<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            // Datos del Usuario Autenticado
            'auth' => [
                'user' => $request->user(),
            ],

            // Mensajes Flash (Notificaciones)
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],

            // IDIOMA ACTUAL (Para que el Tick ✔️ funcione)
            'locale' => app()->getLocale(),

            // TRADUCCIONES (Carga segura del JSON)
            'translations' => function () {
                $locale = app()->getLocale();
                $path = lang_path("{$locale}.json");

                // Solo intentamos leer si el archivo existe para evitar errores
                return file_exists($path)
                    ? json_decode(file_get_contents($path), true)
                    : [];
            },
        ];
    }
}
