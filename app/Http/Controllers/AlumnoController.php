<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::orderBy('apellidos')->paginate(10);
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:alumnos,email',
            'dni' => 'required|string|max:9|unique:alumnos,dni',
            'f_nac' => 'required|date|before:today',
        ]);

        Alumno::create($validated);

        return redirect()->route('alumnos.index')
            ->with('success', __('Alumno creado correctamente'));
    }

    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:alumnos,email,' . $alumno->id,
            'dni' => 'required|string|max:9|unique:alumnos,dni,' . $alumno->id,
            'f_nac' => 'required|date|before:today',
        ]);

        $alumno->update($validated);

        return redirect()->route('alumnos.index')
            ->with('success', __('Alumno actualizado correctamente'));
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        return redirect()->route('alumnos.index')
            ->with('success', __('Alumno eliminado correctamente'));
    }
}
