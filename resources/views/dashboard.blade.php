{{--
================================================================================
VISTA DEL DASHBOARD (Panel Principal) - dashboard.blade.php
================================================================================

Esta es la página principal que ve el usuario después de iniciar sesión.
El contenido que se muestra CAMBIA SEGÚN EL ROL del usuario.

¿CÓMO SE USA ESTA VISTA?
Usa el layout <x-app-layout> que está en layouts/app.blade.php
Todo el contenido de esta vista se inyecta en el {{ $slot }} del layout.

DIRECTIVAS DE SPATIE PERMISSION USADAS:
- @role('nombre')      : Muestra contenido SI el usuario tiene ese rol exacto
- @endrole             : Cierra el bloque @role
- @hasanyrole('a|b')   : Muestra contenido SI tiene ALGUNO de los roles
- @endhasanyrole       : Cierra el bloque @hasanyrole

FUNCIONES IMPORTANTES:
- auth()->user()       : Obtiene el usuario actualmente logueado
- getRoleNames()       : Devuelve colección con los nombres de roles del usuario
- first()              : Obtiene el primer elemento de la colección

ROLES Y LO QUE VEN:
- admin   : Ve todo (panel rojo, tarjeta de alumnos)
- teacher : Ve panel azul y tarjeta de alumnos (solo lectura)
- student : Ve panel verde y tarjeta personal

================================================================================
--}}

{{-- Usamos el layout principal de la aplicación --}}
<x-app-layout>
    
    {{-- Contenedor principal con ancho máximo y padding --}}
    <div class="max-w-7xl mx-auto px-4 py-6">
        
        {{-- ================================================================
             BANNERS DE BIENVENIDA SEGÚN ROL
             Cada rol ve un mensaje diferente con colores distintivos
             ================================================================ --}}
        <div class="mb-6">
            
            {{-- BANNER PARA ADMINISTRADORES (Rojo)
                 @role('admin') solo muestra esto si el usuario tiene rol 'admin' --}}
            @role('admin')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <p class="font-bold">{{ __('Admin Panel') }}</p>
                    <p>{{ __('Full access') }}</p>
                </div>
            @endrole
            
            {{-- BANNER PARA PROFESORES (Azul) --}}
            @role('teacher')
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded">
                    <p class="font-bold">{{ __('Teacher Zone') }}</p>
                    <p>{{ __('Welcome teacher') }}</p>
                </div>
            @endrole
            
            {{-- BANNER PARA ESTUDIANTES (Verde) --}}
            @role('student')
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    <p class="font-bold">{{ __('Student Area') }}</p>
                    <p>{{ __('Welcome student') }}</p>
                </div>
            @endrole
        </div>

        {{-- ================================================================
             INFORMACIÓN DEL ROL ACTUAL
             Muestra qué rol tiene asignado el usuario actual
             ================================================================ --}}
        <div class="mb-6 bg-gray-100 p-3 rounded">
            <span class="text-sm text-gray-600">{{ __('Your current role') }}: </span>
            {{-- getRoleNames() devuelve una colección, first() obtiene el primero
                 ?? 'Sin rol' es el valor por defecto si no tiene roles --}}
            <span class="font-semibold text-gray-800">{{ auth()->user()->getRoleNames()->first() ?? 'Sin rol' }}</span>
        </div>

        {{-- ================================================================
             TARJETA DE ACCESO AL CRUD DE ALUMNOS
             Visible para: admin Y teacher (pero no student)
             ================================================================ --}}
        {{-- @hasanyrole permite listar varios roles separados por | --}}
        @hasanyrole('admin|teacher')
        <div class="w-64 rounded-lg overflow-hidden shadow-lg bg-gradient-to-br from-gray-500 to-gray-700">
            <div class="relative">
                {{-- Imagen decorativa de fondo --}}
                <img src="https://img.freepik.com/free-vector/group-young-people-posing-photo_52683-18824.jpg" alt="Estudiantes" class="w-full h-36 object-cover opacity-80">
                
                {{-- Overlay con gradiente para hacer legible el texto --}}
                <div class="absolute inset-0 bg-gradient-to-t from-gray-800/90 via-gray-700/50 to-transparent"></div>
                
                {{-- Contenido de la tarjeta --}}
                <div class="absolute bottom-0 left-0 right-0 p-3">
                    <h3 class="text-sm font-bold text-white">CRUD Alumnos!</h3>
                    {{-- {!! !!} permite HTML en la traducción si fuera necesario --}}
                    <p class="text-xs text-gray-300 mb-2 leading-tight">{!! __('Manage Students') !!}</p>
                    {{-- Botón que lleva al listado de alumnos --}}
                    <a href="{{ route('alumnos.index') }}" class="inline-block px-4 py-1 bg-blue-600 text-white text-xs rounded">
                        {{ __('View Students') }}
                    </a>
                </div>
            </div>
        </div>
        @endhasanyrole

        {{-- ================================================================
             TARJETA PERSONAL PARA ESTUDIANTES
             Solo visible para usuarios con rol 'student'
             ================================================================ --}}
        @role('student')
        <div class="w-64 rounded-lg overflow-hidden shadow-lg bg-gradient-to-br from-green-500 to-green-700 p-4">
            <h3 class="text-sm font-bold text-white">{{ __('My Area') }}</h3>
            <p class="text-xs text-green-100 mt-2">{{ __('Check info') }}</p>
        </div>
        @endrole

    </div>
</x-app-layout>
