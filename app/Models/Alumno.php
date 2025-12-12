<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'dni',
        'f_nac',
    ];

    protected $casts = [
        'f_nac' => 'date',
    ];
}
