{{--
================================================================================
LISTADO DE ALUMNOS - alumnos/index.blade.php
================================================================================

Vista principal del CRUD de alumnos. Muestra todos los estudiantes en una tabla
con opciones de editar, eliminar y ver detalle.

DATOS RECIBIDOS DEL CONTROLADOR:
- $alumnos: Colección paginada de modelos Alumno (LengthAwarePaginator)
  Viene de: Alumno::orderBy('apellidos')->paginate(10)

PERMISOS Y VISIBILIDAD:
- TODOS: Pueden ver la tabla y el botón "Ver"
- SOLO ADMIN: Puede ver los botones "Crear", "Editar" (lápiz) y "Eliminar" (papelera)
- TEACHER: Ve la tabla pero sin opciones de modificación

CONCEPTOS IMPORTANTES:
- @foreach: Itera sobre la colección de alumnos
- @role: Directiva de Spatie para mostrar contenido según rol
- @csrf: Token de seguridad para formularios POST
- @method('DELETE'): Simula método HTTP DELETE (HTML solo soporta GET/POST)
- session('success'): Mensaje flash de éxito tras una operación
- $alumnos->links(): Genera los enlaces de paginación automáticamente

================================================================================
--}}

{{-- Usamos el layout principal de la aplicación --}}
<x-app-layout>
    
    {{-- ====================================================================
         BARRA DE ACCIONES (Sub-menú)
         Contiene botones de navegación y crear alumno
         ==================================================================== --}}
    <div class="bg-[#0891b2] -mt-4 mb-4">
        <div class="max-w-7xl mx-auto px-4 py-2 flex gap-2">
            
            {{-- BOTÓN CREAR ALUMNO
                 Solo visible para administradores
                 @role('admin') verifica que el usuario tenga rol 'admin' --}}
            @role('admin')
            <a href="{{ route('alumnos.create') }}" class="px-3 py-1 bg-green-600 text-white text-xs rounded">
                {{ __('Create Student') }}
            </a>
            @endrole
            
            {{-- BOTÓN VOLVER AL DASHBOARD
                 Visible para todos los usuarios --}}
            <a href="{{ route('dashboard') }}" class="px-3 py-1 bg-orange-500 text-white text-xs rounded">
                {{ __('Back') }}
            </a>
        </div>
    </div>

    {{-- ====================================================================
         CONTENIDO PRINCIPAL
         ==================================================================== --}}
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- MENSAJE FLASH DE ÉXITO
             Se muestra después de crear, editar o eliminar un alumno
             session('success') contiene el mensaje del controlador --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{-- Traducimos el mensaje por si viene en clave de traducción --}}
                {{ __(session('success')) }}
            </div>
        @endif

        {{-- ================================================================
             TABLA DE ALUMNOS
             Muestra los datos de cada alumno en filas
             ================================================================ --}}
        <table class="w-full">
            {{-- Cabecera de la tabla con nombres de columnas --}}
            <thead>
                <tr class="border-b-2 border-[#0891b2]">
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">id</th>
                    {{-- __() traduce cada título según el idioma --}}
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">{{ __('Name') }} {{ __('Surname') }}</th>
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">{{ __('Date of Birth') }}</th>
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">{{ __('DNI') }}</th>
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">{{ __('Email') }}</th>
                    {{-- Columnas vacías para los botones de acción --}}
                    <th class="py-2 px-2 w-8"></th>
                    <th class="py-2 px-2 w-8"></th>
                    <th class="py-2 px-2 w-10"></th>
                </tr>
            </thead>
            
            {{-- Cuerpo de la tabla - Una fila por cada alumno --}}
            <tbody>
                {{-- @foreach itera sobre cada alumno de la colección paginada --}}
                @foreach($alumnos as $alumno)
                    <tr class="border-b border-gray-200">
                        {{-- COLUMNA ID --}}
                        <td class="py-3 px-2 text-gray-700 text-sm">{{ $alumno->id }}</td>
                        
                        {{-- COLUMNA NOMBRE COMPLETO --}}
                        <td class="py-3 px-2 text-gray-700 text-sm">{{ $alumno->nombre }} {{ $alumno->apellidos }}</td>
                        
                        {{-- COLUMNA FECHA DE NACIMIENTO
                             f_nac es un campo Carbon (fecha), format() da formato --}}
                        <td class="py-3 px-2 text-gray-700 text-sm">{{ $alumno->f_nac->format('Y-m-d') }}</td>
                        
                        {{-- COLUMNA DNI --}}
                        <td class="py-3 px-2 text-gray-700 text-sm">{{ $alumno->dni }}</td>
                        
                        {{-- COLUMNA EMAIL
                             mailto: abre el cliente de correo al hacer clic --}}
                        <td class="py-3 px-2">
                            <a href="mailto:{{ $alumno->email }}" class="text-cyan-600 text-sm">{{ $alumno->email }}</a>
                        </td>
                        
                        {{-- COLUMNA EDITAR
                             Solo visible para administradores --}}
                        <td class="py-3 px-2 text-center">
                            @role('admin')
                            {{-- route() genera la URL /alumnos/{id}/edit --}}
                            <a href="{{ route('alumnos.edit', $alumno) }}" class="text-cyan-500">
                                {{-- Icono de Font Awesome --}}
                                <i class="far fa-edit"></i>
                            </a>
                            @endrole
                        </td>
                        
                        {{-- COLUMNA ELIMINAR
                             Solo visible para administradores
                             Requiere formulario POST con método DELETE --}}
                        <td class="py-3 px-2 text-center">
                            @role('admin')
                            {{-- El formulario envía DELETE a /alumnos/{id}
                                 onsubmit muestra confirmación antes de enviar --}}
                            <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Delete Student?') }}')">
                                {{-- @csrf es obligatorio para formularios POST (seguridad) --}}
                                @csrf
                                {{-- @method simula DELETE ya que HTML no lo soporta --}}
                                @method('DELETE')
                                <button type="submit" class="text-gray-400">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endrole
                        </td>
                        
                        {{-- COLUMNA VER DETALLE
                             Visible para todos los usuarios --}}
                        <td class="py-3 px-2 text-center">
                            <a href="{{ route('alumnos.show', $alumno) }}" class="text-gray-500 text-sm">{{ __('View') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ================================================================
             ENLACES DE PAGINACIÓN
             Laravel genera automáticamente: << 1 2 3 4 5 >>
             ================================================================ --}}
        <div class="mt-4">
            {{-- links() genera los botones de página usando la vista de paginación
                 El estilo se puede personalizar con: php artisan vendor:publish --tag=laravel-pagination --}}
            {{ $alumnos->links() }}
        </div>
    </div>
</x-app-layout>
