<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones via 'php artisan migrate'.
     * Crea la tabla 'estudiantes' en la base de datos.
     */
    public function up(): void
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental (bigint unsigned)
            $table->string('nombre'); // VARCHAR(255)
            $table->string('apellidos');
            $table->string('email')->unique(); // Crea un índice único para evitar emails duplicados
            $table->string('dni')->unique(); // Crea un índice único para el DNI
            $table->date('f_nac'); // Tipo DATE para fecha de nacimiento
            $table->timestamps(); // Crea columnas 'created_at' y 'updated_at' automáticas
        });
    }

    /**
     * Revierte las migraciones via 'php artisan migrate:rollback'.
     * Elimina la tabla 'estudiantes'.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
