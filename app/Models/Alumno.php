<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla manualente ya que no sigue la convención (plural de Alumno sería 'alumnos', no 'estudiantes')
    protected $table = 'estudiantes';

    // Lista blanca de campos que se pueden asignar masivamente (ej. Alumno::create($data))
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'dni',
        'f_nac',
    ];

    // Conversión de tipos automática. 'f_nac' se tratará como un objeto Carbon (fecha)
    protected $casts = [
        'f_nac' => 'date',
    ];
}
