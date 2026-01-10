{{--
================================================================================
PLANTILLA PRINCIPAL DE LA APLICACIÓN - app.blade.php
================================================================================

Esta es la plantilla base (layout) que usan todas las páginas autenticadas.
Define la estructura HTML común: cabecera, navegación y área de contenido.

¿QUÉ ES UN LAYOUT EN BLADE?
Un layout es una plantilla que define la estructura general de la página.
Las vistas hijas "rellenan" las partes variables usando slots o secciones.

COMPONENTES BLADE USADOS:
- <x-dropdown>      : Menú desplegable (en components/dropdown.blade.php)
- <x-dropdown-link> : Enlace dentro del dropdown
- {{ $slot }}       : Contenido que inyecta la vista hija

DIRECTIVAS BLADE IMPORTANTES:
- {{ }}         : Mostrar variable escapada (seguro contra XSS)
- {!! !!}       : Mostrar HTML sin escapar (cuidado con XSS)
- @if / @endif  : Condicional
- @switch       : Selector múltiple
- @csrf         : Token de seguridad para formularios

FUNCIONES USADAS:
- app()->getLocale()   : Obtiene el idioma actual (es, en, fr)
- route('nombre')      : Genera URL a partir del nombre de ruta
- __('texto')          : Traduce el texto según el idioma actual
- Auth::user()         : Obtiene el usuario logueado
- request()->routeIs() : Verifica si estamos en una ruta específica

================================================================================
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    {{-- ====================================================================
         SECCIÓN HEAD - Metadatos, estilos y scripts
         ==================================================================== --}}
    <head>
        {{-- Codificación de caracteres UTF-8 para soportar tildes y ñ --}}
        <meta charset="utf-8">
        
        {{-- Viewport para que sea responsive en móviles --}}
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        {{-- Token CSRF para proteger formularios contra ataques --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        {{-- Título de la pestaña del navegador --}}
        <title>{{ config('app.name', 'School Management') }}</title>
        
        {{-- Fuentes de Google Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        {{-- Iconos de Font Awesome (fa-edit, fa-trash, etc.) --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        
        {{-- CSS y JS compilados por Vite (Tailwind CSS + Alpine.js) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    {{-- ====================================================================
         SECCIÓN BODY - Contenido visible de la página
         ==================================================================== --}}
    <body class="font-sans antialiased m-0 p-0 bg-white">
        
        {{-- ================================================================
             CABECERA PRINCIPAL
             Contiene: Logo, título, nombre de usuario, logout, selectores
             ================================================================ --}}
        <header class="bg-gradient-to-r from-cyan-500 via-cyan-600 to-blue-700 text-white py-3">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                
                {{-- LOGO - Enlace al dashboard --}}
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}">
                        {{-- asset() genera la URL pública al archivo en /public/images --}}
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
                    </a>
                </div>
                
                {{-- TÍTULO Y NOMBRE DE USUARIO --}}
                <div class="flex items-center">
                    <span class="text-4xl font-bold tracking-wide">SCHOOL MANAGEMENT</span>
                    {{-- Auth::user()->name obtiene el nombre del usuario logueado --}}
                    <span class="ml-4 text-lg">{{ Auth::user()->name }}</span>
                </div>
                
                {{-- BOTONES DE LA DERECHA --}}
                <div class="flex items-center gap-3">
                    
                    {{-- FORMULARIO DE LOGOUT
                         Debe ser POST por seguridad (no GET para evitar CSRF)
                         @csrf incluye el token de seguridad --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 bg-gray-700 hover:bg-gray-600 rounded text-sm">
                            {{-- __() traduce el texto según el idioma --}}
                            {{ __('Log Out') }}
                        </button>
                    </form>

                    {{-- ============================================================
                         SELECTOR DE ROLES (Solo visible en Dashboard)
                         Permite cambiar rápidamente entre usuarios de prueba
                         ============================================================ --}}
                    {{-- request()->routeIs() verifica si la URL actual es 'dashboard' --}}
                    @if(request()->routeIs('dashboard'))
                    <div class="ml-2 relative">
                        {{-- x-dropdown es un componente Blade que usa Alpine.js --}}
                        <x-dropdown align="right" width="48">
                            {{-- Slot "trigger": El botón que abre el dropdown --}}
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Switch Role') }}</div>
                                    {{-- Icono de flecha hacia abajo (SVG) --}}
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            {{-- Slot "content": Los enlaces del dropdown --}}
                            <x-slot name="content">
                                {{-- Cada enlace llama a /login-role/{rol} para cambiar de usuario --}}
                                <x-dropdown-link :href="route('login.role', 'admin')">Admin</x-dropdown-link>
                                <x-dropdown-link :href="route('login.role', 'teacher')">Teacher</x-dropdown-link>
                                <x-dropdown-link :href="route('login.role', 'student')">Student</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    {{-- ============================================================
                         SELECTOR DE IDIOMAS
                         Visible en todas las páginas para cambiar entre ES/EN/FR
                         ============================================================ --}}
                    <div class="ml-2 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        {{-- @switch muestra el idioma actual con su bandera --}}
                                        @switch(app()->getLocale())
                                            @case('es') <img src="https://flagcdn.com/w40/es.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> ES @break
                                            @case('en') <img src="https://flagcdn.com/w40/gb.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> EN @break
                                            @case('fr') <img src="https://flagcdn.com/w40/fr.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> FR @break
                                        @endswitch
                                    </div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                {{-- Enlaces a /lang/{codigo} para cambiar idioma --}}
                                <x-dropdown-link :href="route('lang.switch', 'es')">
                                    <div class="flex items-center">
                                        <img src="https://flagcdn.com/w40/es.png" class="h-3 w-5 object-cover mr-2"> Español
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('lang.switch', 'en')">
                                    <div class="flex items-center">
                                        <img src="https://flagcdn.com/w40/gb.png" class="h-3 w-5 object-cover mr-2"> English
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('lang.switch', 'fr')">
                                    <div class="flex items-center">
                                        <img src="https://flagcdn.com/w40/fr.png" class="h-3 w-5 object-cover mr-2"> Français
                                    </div>
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </header>

        {{-- ================================================================
             BARRA DE NAVEGACIÓN SECUNDARIA
             Enlaces rápidos a secciones de la app
             ================================================================ --}}
        <nav class="bg-[#0891b2] py-2">
            <div class="max-w-7xl mx-auto px-4 flex gap-2">
                {{-- Cada enlace usa __() para que el texto se traduzca --}}
                <a href="{{ route('profile.edit') }}" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('Profile') }}</a>
                <a href="#about" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('About') }}</a>
                <a href="#contact" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('Contact') }}</a>
                <a href="#news" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('News') }}</a>
                <a href="#references" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('References') }}</a>
            </div>
        </nav>

        {{-- ================================================================
             CONTENIDO PRINCIPAL
             {{ $slot }} es donde se inyecta el contenido de cada vista
             Cuando una vista usa <x-app-layout>, su contenido va aquí
             ================================================================ --}}
        <main class="py-4">
            {{ $slot }}
        </main>
    </body>
</html>
