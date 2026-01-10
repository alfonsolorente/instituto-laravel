<?php
/**
 * =============================================================================
 * ARCHIVO DE RUTAS WEB - routes/web.php
 * =============================================================================
 * 
 * Este archivo define todas las rutas HTTP de la aplicación web.
 * Las rutas conectan URLs con controladores o funciones que devuelven vistas.
 * 
 * CONCEPTOS CLAVE:
 * - Route::get()    -> Peticiones GET (cargar páginas)
 * - Route::post()   -> Peticiones POST (enviar formularios)
 * - Route::patch()  -> Peticiones PATCH (actualizar parcialmente)
 * - Route::delete() -> Peticiones DELETE (eliminar recursos)
 * - Route::resource() -> Crea automáticamente las 7 rutas CRUD estándar
 * 
 * MIDDLEWARES USADOS:
 * - 'auth'      -> Requiere que el usuario esté logueado
 * - 'verified'  -> Requiere que el email esté verificado
 * - 'role:X'    -> Requiere que el usuario tenga el rol X (Spatie Permission)
 * 
 * =============================================================================
 */

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// =============================================================================
// RUTAS PÚBLICAS (Accesibles sin autenticación)
// =============================================================================

/**
 * RUTA PRINCIPAL / LANDING PAGE
 * URL: /
 * Carga la vista de bienvenida (welcome.blade.php)
 * Esta es la primera página que ven los visitantes
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * CAMBIO DE IDIOMA
 * URL: /lang/{locale}
 * Ejemplo: /lang/es, /lang/en, /lang/fr
 * 
 * Funcionamiento:
 * 1. Recibe el código de idioma como parámetro ({locale})
 * 2. Valida que sea uno de los idiomas soportados (es, en, fr)
 * 3. Guarda la selección en la sesión para que persista entre páginas
 * 4. Establece el idioma de la aplicación (App::setLocale)
 * 5. Redirige de vuelta a la página anterior
 * 
 * El middleware SetLocale (en bootstrap/app.php) se encarga de leer
 * la sesión en cada petición y aplicar el idioma guardado.
 */
Route::get('/lang/{locale}', function (string $locale) {
    // Solo permitimos idiomas válidos para evitar errores
    if (in_array($locale, ['en', 'es', 'fr'])) {
        Session::put('locale', $locale);  // Guardar en sesión
        App::setLocale($locale);          // Aplicar inmediatamente
    }
    return redirect()->back();  // Volver a la página donde estaba el usuario
})->name('lang.switch');

/**
 * LOGIN RÁPIDO POR ROL (SOLO PARA DESARROLLO/DEMO)
 * URL: /login-role/{role}
 * Ejemplo: /login-role/admin, /login-role/teacher, /login-role/student
 * 
 * ⚠️ IMPORTANTE: ELIMINAR ESTA RUTA EN PRODUCCIÓN ⚠️
 * 
 * Funcionamiento:
 * 1. Recibe el nombre del rol como parámetro
 * 2. Busca el email correspondiente (admin@instituto.com, etc.)
 * 3. Busca el usuario en la base de datos
 * 4. Si existe, lo loguea automáticamente sin contraseña
 * 5. Redirige al Dashboard
 * 
 * Esta ruta existe para facilitar las pruebas y demostraciones,
 * permitiendo cambiar entre roles rápidamente sin recordar contraseñas.
 */
Route::get('/login-role/{role}', function ($role) {
    // Mapa de roles a emails de usuarios de prueba
    $email = '';
    switch ($role) {
        case 'admin':
            $email = 'admin@instituto.com';
            break;
        case 'teacher':
            $email = 'teacher@instituto.com';
            break;
        case 'student':
            $email = 'student@instituto.com';
            break;
        default:
            // Si el rol no es válido, redirigir a inicio
            return redirect('/');
    }
    
    // Buscar el usuario en la base de datos por su email
    $user = \App\Models\User::where('email', $email)->first();
    
    if ($user) {
        // Si encontramos el usuario, forzar el login
        Illuminate\Support\Facades\Auth::login($user);
        return redirect('/dashboard');
    }
    
    // Si no existe el usuario, mostrar error
    return redirect('/')->with('error', 'Usuario demo no encontrado. Por favor ejecuta: php artisan migrate:fresh --seed');
})->name('login.role');

// =============================================================================
// RUTAS PROTEGIDAS (Requieren autenticación)
// =============================================================================

/**
 * DASHBOARD / PANEL PRINCIPAL
 * URL: /dashboard
 * 
 * Middlewares aplicados:
 * - 'auth': Solo usuarios logueados pueden acceder
 * - 'verified': Solo si han verificado su email (opcional según config)
 * 
 * Esta es la página principal tras iniciar sesión.
 * Muestra diferentes contenidos según el rol del usuario.
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * GRUPO DE RUTAS AUTENTICADAS
 * 
 * Todas las rutas dentro de este grupo requieren que el usuario
 * esté logueado. Si intenta acceder sin estar logueado,
 * Laravel lo redirigirá automáticamente a la página de login.
 */
Route::middleware('auth')->group(function () {
    
    // -------------------------------------------------------------------------
    // RUTAS DE PERFIL DE USUARIO
    // -------------------------------------------------------------------------
    
    /**
     * Ver/Editar Perfil: GET /profile
     * Muestra el formulario de edición del perfil del usuario actual
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    /**
     * Actualizar Perfil: PATCH /profile
     * Procesa los cambios del formulario de perfil (nombre, email)
     */
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    /**
     * Eliminar Cuenta: DELETE /profile
     * Permite al usuario borrar permanentemente su cuenta
     */
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // -------------------------------------------------------------------------
    // RUTAS CRUD DE ALUMNOS
    // -------------------------------------------------------------------------
    
    /**
     * CRUD COMPLETO DE ALUMNOS
     * 
     * Route::resource() crea automáticamente las 7 rutas estándar:
     * 
     * | Método HTTP | URI                   | Acción     | Nombre de Ruta    |
     * |-------------|-----------------------|------------|-------------------|
     * | GET         | /alumnos              | index      | alumnos.index     |
     * | GET         | /alumnos/create       | create     | alumnos.create    |
     * | POST        | /alumnos              | store      | alumnos.store     |
     * | GET         | /alumnos/{alumno}     | show       | alumnos.show      |
     * | GET         | /alumnos/{alumno}/edit| edit       | alumnos.edit      |
     * | PUT/PATCH   | /alumnos/{alumno}     | update     | alumnos.update    |
     * | DELETE      | /alumnos/{alumno}     | destroy    | alumnos.destroy   |
     * 
     * El controlador AlumnoController tiene un método para cada acción.
     * Algunas acciones están protegidas solo para administradores.
     */
    Route::resource('alumnos', AlumnoController::class);

    // -------------------------------------------------------------------------
    // RUTAS DE ADMINISTRADOR
    // -------------------------------------------------------------------------
    
    /**
     * PANEL DE ADMINISTRACIÓN
     * URL: /admin
     * 
     * Doble protección:
     * 1. Middleware 'auth': Requiere estar logueado
     * 2. Middleware 'role:admin': Requiere tener el rol 'admin' (Spatie Permission)
     * 
     * Si un usuario sin rol admin intenta acceder, recibirá un error 403 (Forbidden)
     */
    Route::middleware(['auth', \Spatie\Permission\Middlewares\RoleMiddleware::class . ':admin'])->prefix('admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    });
});

// =============================================================================
// RUTAS DE AUTENTICACIÓN (Laravel Breeze)
// =============================================================================

/**
 * Carga las rutas de autenticación generadas por Laravel Breeze:
 * - GET/POST /login          -> Iniciar sesión
 * - POST /logout             -> Cerrar sesión
 * - GET/POST /register       -> Registrarse
 * - GET/POST /forgot-password -> Recuperar contraseña
 * - etc.
 * 
 * Estas rutas están definidas en routes/auth.php
 */
require __DIR__.'/auth.php';
