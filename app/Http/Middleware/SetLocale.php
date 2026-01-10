<?php
/**
 * =============================================================================
 * MIDDLEWARE DE IDIOMA - SetLocale.php
 * =============================================================================
 * 
 * Este middleware se ejecuta en CADA petición HTTP y se encarga de
 * mantener el idioma seleccionado por el usuario entre páginas.
 * 
 * ¿QUÉ ES UN MIDDLEWARE?
 * Un middleware es código que se ejecuta ANTES de que la petición llegue
 * al controlador. Es como un "filtro" que puede modificar la petición
 * o la respuesta, o incluso bloquear el acceso.
 * 
 * FLUJO DE FUNCIONAMIENTO:
 * 1. Usuario selecciona idioma -> Se guarda en sesión (/lang/es)
 * 2. Usuario navega a otra página
 * 3. SetLocale lee la sesión y aplica el idioma guardado
 * 4. La página se renderiza en el idioma correcto
 * 
 * REGISTRO DEL MIDDLEWARE:
 * Este middleware está registrado en bootstrap/app.php para que
 * se ejecute en todas las peticiones web automáticamente.
 * 
 * =============================================================================
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Manejar la petición entrante.
     *
     * @param  Request  $request  La petición HTTP entrante
     * @param  Closure  $next     La siguiente capa del middleware
     * @return Response           La respuesta HTTP
     * 
     * FUNCIONAMIENTO:
     * 1. Comprueba si existe un idioma guardado en la sesión
     * 2. Si existe, lo aplica a toda la aplicación
     * 3. Continúa con la petición (llama al siguiente middleware o controlador)
     * 
     * Si no hay idioma en sesión, se usa el idioma por defecto (config/app.php -> locale)
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si hay un idioma guardado en la sesión del usuario
        if (Session::has('locale')) {
            // Obtener el idioma de la sesión y aplicarlo
            // App::setLocale() cambia el idioma de toda la aplicación
            // Esto afecta a __(), trans(), y los archivos de traducción
            App::setLocale(Session::get('locale'));
        }
        
        // Continuar con la petición
        // $next($request) pasa la petición al siguiente middleware o controlador
        return $next($request);
    }
}
