<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * CONTROLADOR DE ADMINISTRACIÓN
 * 
 * Gestiona el acceso al panel principal para usuarios con rol de administrador.
 */
class AdminController extends Controller
{
    /**
     * Muestra la vista principal del panel del administrador.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
