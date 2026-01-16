<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MODELO DE ALUMNO
 * 
 * Gestiona los datos de los estudiantes registrados en el instituto.
 * Mapea directamente con la tabla 'estudiantes'.
 */
/**
 * MODELO DE ALUMNO
 * 
 * Gestiona la información de los estudiantes. Aunque la clase se llama Alumno,
 * está vinculada a la tabla 'estudiantes' en la base de datos.
 */
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
