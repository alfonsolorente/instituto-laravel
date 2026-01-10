<?php
/**
 * =============================================================================
 * CONTROLADOR DE ALUMNOS - AlumnoController.php
 * =============================================================================
 * 
 * Este controlador gestiona todas las operaciones CRUD (Crear, Leer, Actualizar,
 * Eliminar) para la entidad "Alumno" (estudiantes del instituto).
 * 
 * ESTRUCTURA CRUD:
 * - index()   -> Listar todos los alumnos
 * - create()  -> Mostrar formulario de creación
 * - store()   -> Guardar nuevo alumno en BD
 * - show()    -> Ver detalle de un alumno
 * - edit()    -> Mostrar formulario de edición
 * - update()  -> Actualizar alumno existente
 * - destroy() -> Eliminar alumno
 * 
 * PERMISOS:
 * - TODOS pueden ver (index, show)
 * - SOLO ADMIN puede modificar (create, store, edit, update, destroy)
 * 
 * CONCEPTOS CLAVE UTILIZADOS:
 * - Route Model Binding: Laravel inyecta automáticamente el modelo desde la URL
 * - Validación de Request: Verificar datos antes de guardar
 * - Mensajes Flash: Mostrar notificaciones tras acciones
 * - Spatie Roles: Sistema de autorización por roles
 * 
 * =============================================================================
 */

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * =========================================================================
     * INDEX - Listar todos los alumnos
     * =========================================================================
     * URL: GET /alumnos
     * Vista: alumnos/index.blade.php
     * 
     * Funcionamiento:
     * 1. Consulta todos los alumnos de la base de datos
     * 2. Los ordena alfabéticamente por apellidos
     * 3. Aplica paginación de 10 elementos por página
     * 4. Pasa la colección paginada a la vista
     * 
     * La paginación permite navegar entre páginas sin cargar todos los registros.
     * Laravel genera automáticamente los enlaces de paginación.
     */
    public function index()
    {
        // Obtener alumnos ordenados por apellidos, 10 por página
        $alumnos = Alumno::orderBy('apellidos')->paginate(10);
        
        // compact('alumnos') es equivalente a ['alumnos' => $alumnos]
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * =========================================================================
     * CREATE - Mostrar formulario de creación
     * =========================================================================
     * URL: GET /alumnos/create
     * Vista: alumnos/create.blade.php
     * 
     * PROTECCIÓN: Solo administradores pueden acceder.
     * Si un usuario sin rol 'admin' intenta acceder, recibe error 403.
     * 
     * El formulario que se muestra enviará los datos mediante POST a store()
     */
    public function create()
    {
        // Verificar que el usuario tenga rol de administrador
        // hasRole() es un método de Spatie Permission
        if (!auth()->user()->hasRole('admin')) {
            abort(403); // Error 403: Acceso prohibido
        }
        
        return view('alumnos.create');
    }

    /**
     * =========================================================================
     * STORE - Guardar nuevo alumno en la base de datos
     * =========================================================================
     * URL: POST /alumnos
     * 
     * PROTECCIÓN: Solo administradores pueden crear alumnos.
     * 
     * Funcionamiento:
     * 1. Verificar permisos del usuario
     * 2. Validar todos los datos recibidos del formulario
     * 3. Si la validación falla, Laravel redirige automáticamente con errores
     * 4. Si pasa, crear el registro en la base de datos
     * 5. Redirigir al listado con mensaje de éxito
     * 
     * REGLAS DE VALIDACIÓN:
     * - nombre: obligatorio, texto, máximo 255 caracteres
     * - apellidos: obligatorio, texto, máximo 255 caracteres
     * - email: obligatorio, formato email válido, único en la tabla
     * - dni: obligatorio, máximo 9 caracteres, único en la tabla
     * - f_nac: obligatorio, fecha, debe ser anterior a hoy
     */
    public function store(Request $request)
    {
        // Protección: Solo admins pueden crear
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        // Validar los datos del formulario
        // Si falla, Laravel redirige automáticamente con los errores
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:estudiantes,email',
            'dni' => 'required|string|max:9|unique:estudiantes,dni',
            'f_nac' => 'required|date|before:today',
        ]);

        // Crear el alumno con los datos validados
        // El modelo Alumno debe tener $fillable configurado
        Alumno::create($validated);

        // Redirigir al listado con mensaje flash de éxito
        // El __() traduce el mensaje según el idioma actual
        return redirect()->route('alumnos.index')
            ->with('success', __('Alumno creado correctamente'));
    }

    /**
     * =========================================================================
     * SHOW - Mostrar detalle de un alumno específico
     * =========================================================================
     * URL: GET /alumnos/{alumno}
     * Ejemplo: GET /alumnos/5
     * Vista: alumnos/show.blade.php
     * 
     * ROUTE MODEL BINDING:
     * Laravel detecta que el parámetro se llama $alumno y el tipo es Alumno,
     * entonces busca automáticamente el alumno con ID=5 en la base de datos
     * y lo inyecta como objeto. Si no existe, devuelve error 404.
     * 
     * Esto es equivalente a:
     * $alumno = Alumno::findOrFail($id);
     * 
     * PERMISOS: Todos los usuarios autenticados pueden ver el detalle.
     */
    public function show(Alumno $alumno)
    {
        // $alumno ya contiene el modelo gracias a Route Model Binding
        return view('alumnos.show', compact('alumno'));
    }

    /**
     * =========================================================================
     * EDIT - Mostrar formulario de edición
     * =========================================================================
     * URL: GET /alumnos/{alumno}/edit
     * Ejemplo: GET /alumnos/5/edit
     * Vista: alumnos/edit.blade.php
     * 
     * PROTECCIÓN: Solo administradores pueden editar.
     * 
     * El formulario mostrará los datos actuales del alumno
     * y enviará los cambios mediante PUT/PATCH a update()
     */
    public function edit(Alumno $alumno)
    {
        // Protección: Solo admins pueden editar
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        
        return view('alumnos.edit', compact('alumno'));
    }

    /**
     * =========================================================================
     * UPDATE - Actualizar datos de un alumno existente
     * =========================================================================
     * URL: PUT/PATCH /alumnos/{alumno}
     * 
     * PROTECCIÓN: Solo administradores pueden actualizar.
     * 
     * Funcionamiento similar a store(), pero:
     * - En las reglas de unicidad, ignoramos el ID actual del alumno
     *   para que no falle si el email/dni no ha cambiado
     * - Usamos update() en lugar de create()
     */
    public function update(Request $request, Alumno $alumno)
    {
        // Protección: Solo admins pueden actualizar
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        // Validar datos, ignorando el ID actual en las reglas de unicidad
        // El formato es: unique:tabla,columna,id_a_ignorar
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:estudiantes,email,' . $alumno->id,
            'dni' => 'required|string|max:9|unique:estudiantes,dni,' . $alumno->id,
            'f_nac' => 'required|date|before:today',
        ]);

        // Actualizar el modelo con los datos validados
        $alumno->update($validated);

        return redirect()->route('alumnos.index')
            ->with('success', __('Alumno actualizado correctamente'));
    }

    /**
     * =========================================================================
     * DESTROY - Eliminar un alumno de la base de datos
     * =========================================================================
     * URL: DELETE /alumnos/{alumno}
     * 
     * PROTECCIÓN: Solo administradores pueden eliminar.
     * 
     * El método delete() elimina el registro de la base de datos.
     * Es una eliminación permanente (no hay papelera).
     * 
     * En la vista, antes de enviar la petición DELETE, se muestra
     * una confirmación JavaScript para evitar eliminaciones accidentales.
     */
    public function destroy(Alumno $alumno)
    {
        // Protección: Solo admins pueden eliminar
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        // Eliminar el registro de la base de datos
        $alumno->delete();

        return redirect()->route('alumnos.index')
            ->with('success', __('Alumno eliminado correctamente'));
    }
}
