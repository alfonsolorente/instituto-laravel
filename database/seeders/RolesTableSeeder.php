<?php
/**
 * =============================================================================
 * SEEDER DE ROLES - RolesTableSeeder.php
 * =============================================================================
 * 
 * Este seeder crea los roles del sistema usando Spatie Laravel Permission.
 * 
 * ¿QUÉ ES SPATIE PERMISSION?
 * Es un paquete de Laravel que permite gestionar roles y permisos.
 * - Roles: Agrupaciones de permisos (admin, teacher, student)
 * - Permisos: Acciones específicas (create-post, delete-user)
 * 
 * En esta aplicación usamos SOLO ROLES (sin permisos individuales)
 * para simplificar. Los roles definen qué puede hacer cada tipo de usuario.
 * 
 * ROLES DEL SISTEMA:
 * - student: Rol básico, solo puede ver su información
 * - teacher: Puede ver todos los alumnos (solo lectura)
 * - admin:   Acceso total, puede crear/editar/eliminar alumnos
 * 
 * CÓMO VERIFICAR ROLES EN EL CÓDIGO:
 * - En PHP: auth()->user()->hasRole('admin')
 * - En Blade: @role('admin') ... @endrole
 * - En rutas: ->middleware('role:admin')
 * 
 * =============================================================================
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;  // Modelo de Spatie para roles
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Ejecutar el seeder para crear roles y asignar el rol admin.
     * 
     * Este seeder es llamado desde DatabaseSeeder usando $this->call()
     * Se ejecuta DESPUÉS de crear los usuarios para poder asignar roles.
     */
    public function run(): void
    {
        // =====================================================================
        // PASO 1: CREAR LOS ROLES DEL SISTEMA
        // =====================================================================
        
        /**
         * Role::firstOrCreate() busca el rol por nombre.
         * - Si existe, lo devuelve sin hacer nada
         * - Si no existe, lo crea
         * 
         * Esto permite ejecutar el seeder múltiples veces sin crear duplicados.
         * Es más seguro que Role::create() que fallaría en la segunda ejecución.
         * 
         * Los roles se guardan en la tabla 'roles' (creada por la migración de Spatie)
         */
        Role::firstOrCreate(['name' => 'student']);  // Rol de estudiante
        Role::firstOrCreate(['name' => 'teacher']);  // Rol de profesor
        Role::firstOrCreate(['name' => 'admin']);    // Rol de administrador

        // =====================================================================
        // PASO 2: ASIGNAR ROL ADMIN AL USUARIO ADMINISTRADOR
        // =====================================================================
        
        /**
         * Buscamos al usuario administrador por su email.
         * El email 'admin@instituto.com' se define en DatabaseSeeder.
         * 
         * first() devuelve el primer resultado o null si no existe.
         */
        $admin = User::where('email', 'admin@instituto.com')->first();
        
        /**
         * Verificamos antes de asignar:
         * 1. Que el usuario exista ($admin no sea null)
         * 2. Que no tenga ya el rol (para evitar duplicados)
         * 
         * hasRole() verifica si el usuario tiene un rol específico
         * assignRole() asigna un rol al usuario (crea registro en model_has_roles)
         * 
         * La relación usuario-rol se guarda en la tabla 'model_has_roles'
         */
        if ($admin && !$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
