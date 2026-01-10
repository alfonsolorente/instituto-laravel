<?php
/**
 * =============================================================================
 * SEEDER PRINCIPAL DE BASE DE DATOS - DatabaseSeeder.php
 * =============================================================================
 * 
 * Los Seeders son clases que insertan datos de prueba en la base de datos.
 * Son útiles para:
 * - Desarrollo: Tener datos con los que trabajar
 * - Testing: Datos consistentes para tests automatizados
 * - Demo: Mostrar la aplicación con contenido
 * 
 * CÓMO EJECUTAR ESTE SEEDER:
 * - php artisan db:seed              -> Solo ejecuta seeders
 * - php artisan migrate:fresh --seed -> Borra todo, recrea tablas y ejecuta seeders
 * 
 * Este seeder crea:
 * 1. Tres usuarios de prueba (Admin, Profesor, Estudiante)
 * 2. Sus respectivos roles usando Spatie Permission
 * 3. 10 alumnos ficticios generados por Factory
 * 
 * CREDENCIALES DE PRUEBA (todos con contraseña: "password"):
 * - admin@instituto.com   -> Rol: admin    -> Acceso completo
 * - teacher@instituto.com -> Rol: teacher  -> Solo lectura de alumnos
 * - student@instituto.com -> Rol: student  -> Acceso limitado
 * 
 * =============================================================================
 */

namespace Database\Seeders;

use App\Models\User;
use App\Models\Alumno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Trait que evita disparar eventos del modelo durante el seeding.
     * Mejora el rendimiento al insertar muchos registros.
     */
    use WithoutModelEvents;

    /**
     * Ejecutar el seeder de la base de datos.
     * 
     * Este método se llama cuando ejecutas: php artisan db:seed
     * El orden de las operaciones es importante para que funcionen las relaciones.
     */
    public function run(): void
    {
        // =====================================================================
        // PASO 1: CREAR USUARIOS DE PRUEBA
        // =====================================================================
        
        /**
         * User::factory()->create() usa el Factory para generar un usuario.
         * Le pasamos datos específicos para sobrescribir los valores aleatorios.
         * bcrypt() encripta la contraseña antes de guardarla.
         * 
         * Los factories están en database/factories/UserFactory.php
         */
        
        // Usuario Administrador - Tiene acceso total a la aplicación
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@instituto.com',
            'password' => bcrypt('password'), // Contraseña: password
        ]);

        // Usuario Profesor - Puede ver alumnos pero no modificarlos
        $teacher = User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@instituto.com',
            'password' => bcrypt('password'),
        ]);

        // Usuario Estudiante - Acceso limitado a su propia información
        $student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@instituto.com',
            'password' => bcrypt('password'),
        ]);

        // =====================================================================
        // PASO 2: CREAR ROLES Y ASIGNAR AL ADMIN
        // =====================================================================
        
        /**
         * $this->call() ejecuta otro seeder.
         * RolesTableSeeder crea los roles 'admin', 'teacher', 'student'
         * y asigna automáticamente el rol 'admin' al usuario admin@instituto.com
         * 
         * Es importante llamar a este seeder DESPUÉS de crear los usuarios
         * para que pueda encontrar al admin por email.
         */
        $this->call(RolesTableSeeder::class);

        // =====================================================================
        // PASO 3: ASIGNAR ROLES A LOS DEMÁS USUARIOS
        // =====================================================================
        
        /**
         * assignRole() es un método de Spatie Permission (trait HasRoles).
         * Asigna un rol existente al usuario.
         * El rol debe existir previamente (creado por RolesTableSeeder).
         */
        $teacher->assignRole('teacher');
        $student->assignRole('student');

        // =====================================================================
        // PASO 4: CREAR ALUMNOS DE PRUEBA
        // =====================================================================
        
        /**
         * Alumno::factory(10)->create() genera 10 alumnos con datos ficticios.
         * Los datos se generan según las reglas del AlumnoFactory.
         * Esto llena la tabla de alumnos para poder probar la paginación,
         * el listado, la búsqueda, etc.
         */
        Alumno::factory(10)->create();
    }
}
