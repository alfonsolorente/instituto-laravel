<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /**
     * Trait HasFactory: Permite usar factories para crear usuarios en pruebas y seeders.
     * Trait Notifiable: Permite enviar notificaciones (email, slack, etc.) al usuario.
     * Trait HasRoles: Añadido por el paquete Spatie/Laravel-Permission para gestionar roles y permisos.
     */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Los atributos que son asignables masivamente.
     * Esto protege contra asignaciones masivas no deseadas (Mass Assignment Vulnerability).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     * Por ejemplo, cuando se convierte el modelo a JSON, estos campos no aparecerán.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define conversiones automáticas de tipos de datos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convierte la fecha de verificación a objeto DateTime
            'password' => 'hashed',            // Hashea automáticamente la contraseña al guardarla
        ];
    }
}
