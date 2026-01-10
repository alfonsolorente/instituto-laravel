{{--
================================================================================
PÁGINA DE BIENVENIDA / LANDING PAGE - welcome.blade.php
================================================================================

Esta es la primera página que ven los visitantes. Es PÚBLICA, no requiere login.
Sirve como punto de entrada a la aplicación.

CARACTERÍSTICAS:
- Diseño atractivo con imagen de fondo y título llamativo
- Botones de Login y Registro para visitantes no autenticados
- Botón al Dashboard para usuarios ya logueados
- Selector de idiomas (Español, Inglés, Francés)
- Botones de Demo para pruebas rápidas

DIRECTIVAS BLADE USADAS:
- @auth     : Muestra contenido SOLO si el usuario está logueado
- @else     : Alternativa al @auth
- @endauth  : Cierra el bloque @auth
- @guest    : Muestra contenido SOLO si es visitante (no logueado)
- @endguest : Cierra el bloque @guest

ALPINE.JS:
Alpine.js es un framework JavaScript minimalista para interactividad.
- x-data="{ open: false }" : Define el estado inicial (dropdown cerrado)
- @click="open = !open"    : Alterna el estado al hacer clic
- @click.away="open = false": Cierra al hacer clic fuera
- x-show="open"            : Muestra/oculta según el estado

IMPORTANTE: Esta vista NO usa un layout (<x-app-layout>), es HTML completo.
Esto es porque la landing page tiene un diseño único diferente al resto.

================================================================================
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    {{-- ====================================================================
         SECCIÓN HEAD
         Metadatos, estilos y scripts necesarios
         ==================================================================== --}}
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        {{-- config() lee valores de config/app.php --}}
        <title>{{ config('app.name', 'School Management') }}</title>
        
        {{-- Fuentes de Google Fonts para tipografías modernas --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        {{-- Font Awesome para iconos (fa-twitter, fa-facebook, etc.) --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        
        {{-- @vite carga CSS y JS compilados
             Incluye Tailwind CSS y Alpine.js --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans antialiased m-0 p-0">
        
        {{-- ================================================================
             CABECERA PRINCIPAL
             Logo, título y botones de autenticación/idioma
             ================================================================ --}}
        <header class="bg-[#1e2a4a] text-white py-2">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                
                {{-- LOGO - Enlace a la página principal --}}
                <div class="flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto">
                    </a>
                </div>
                
                {{-- TÍTULO DE LA APLICACIÓN --}}
                <div class="text-3xl font-bold tracking-wide">
                    SCHOOL MANAGEMENT
                </div>
                
                {{-- BOTONES DERECHA --}}
                <div class="flex items-center gap-2">
                    
                    {{-- CONTENIDO PARA USUARIOS AUTENTICADOS
                         @auth muestra esto solo si hay sesión activa --}}
                    @auth
                        {{-- Nombre del usuario logueado --}}
                        <span class="mr-2">{{ Auth::user()->name }}</span>
                        
                        {{-- Formulario de logout (debe ser POST por seguridad) --}}
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-1 border border-gray-400 rounded text-sm">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    
                    {{-- CONTENIDO PARA VISITANTES NO AUTENTICADOS --}}
                    @else
                        {{-- Botón de Login --}}
                        <a href="{{ route('login') }}" class="px-4 py-1 border border-gray-400 rounded text-sm">
                            {{ __('Login') }}
                        </a>
                        
                        {{-- Botón de Registro --}}
                        <a href="{{ route('register') }}" class="px-4 py-1 border border-gray-400 rounded text-sm">
                            {{ __('Register') }}
                        </a>
                    @endauth
                    
                    {{-- ========================================================
                         SELECTOR DE IDIOMAS CON ALPINE.JS
                         Funciona sin recargar la página para abrir/cerrar
                         ======================================================== --}}
                    {{-- x-data inicializa Alpine con estado open=false --}}
                    <div class="relative ml-4 border-l border-gray-500 pl-4" x-data="{ open: false }">
                        
                        {{-- Botón que abre/cierra el dropdown --}}
                        {{-- @click alterna el estado, @click.away lo cierra al clicar fuera --}}
                        <button @click="open = !open" @click.away="open = false" class="flex items-center text-sm font-medium text-gray-300 hover:text-white transition duration-150 ease-in-out focus:outline-none">
                            <div>
                                {{-- Muestra la bandera e idioma actual --}}
                                @switch(app()->getLocale())
                                    @case('es') <img src="https://flagcdn.com/w40/es.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> Español @break
                                    @case('en') <img src="https://flagcdn.com/w40/gb.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> English @break
                                    @case('fr') <img src="https://flagcdn.com/w40/fr.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> Français @break
                                @endswitch
                            </div>
                            {{-- Icono de flecha hacia abajo --}}
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        {{-- Menú desplegable de idiomas
                             x-show controla la visibilidad según el estado 'open' --}}
                        <div x-show="open" 
                             style="display: none;"
                             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                
                                {{-- Enlace para cambiar a Español --}}
                                <a href="{{ route('lang.switch', 'es') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" role="menuitem">
                                    <img src="https://flagcdn.com/w40/es.png" class="h-3 w-5 object-cover mr-2"> Español
                                </a>
                                
                                {{-- Enlace para cambiar a Inglés --}}
                                <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" role="menuitem">
                                    <img src="https://flagcdn.com/w40/gb.png" class="h-3 w-5 object-cover mr-2"> English
                                </a>
                                
                                {{-- Enlace para cambiar a Francés --}}
                                <a href="{{ route('lang.switch', 'fr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" role="menuitem">
                                    <img src="https://flagcdn.com/w40/fr.png" class="h-3 w-5 object-cover mr-2"> Français
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ================================================================
             BARRA DE NAVEGACIÓN SECUNDARIA
             Enlaces a secciones de la página (anclas)
             ================================================================ --}}
        <nav class="bg-[#0891b2] py-2">
            <div class="max-w-7xl mx-auto px-4 flex gap-2">
                {{-- Los # hacen scroll a secciones con esos IDs --}}
                <a href="#about" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('About') }}</a>
                <a href="#contacta" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('Contacta') }}</a>
                <a href="#noticias" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('Noticias') }}</a>
                <a href="#referencias" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">{{ __('Referencias') }}</a>
            </div>
        </nav>

        {{-- ================================================================
             SECCIÓN HERO (Principal visual)
             Imagen de fondo con mensaje principal y botones de acción
             ================================================================ --}}
        <main class="relative h-[420px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1476973422084-e0fa66ff9456?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
            
            {{-- Overlay oscuro para mejorar legibilidad del texto --}}
            <div class="absolute inset-0 bg-black/30"></div>
            
            {{-- Contenido centrado vertical y horizontalmente --}}
            <div class="relative h-full flex flex-col items-center justify-center text-white text-center">
                
                {{-- Título principal animado --}}
                <h1 class="text-5xl font-bold italic text-yellow-400 mb-0">{{ __('Aprendiendo') }}</h1>
                <h1 class="text-5xl font-bold italic text-yellow-400 mb-4">{{ __('Laravel') }}</h1>
                
                {{-- Subtítulos descriptivos --}}
                <p class="text-gray-300 text-sm mb-1">{{ __('Aplicacion para aprender Laravel') }}</p>
                <p class="text-gray-300 text-sm mb-4">{{ __('Registrate para acceder a las opciones') }}</p>
                
                {{-- BOTONES DE ACCIÓN
                     @guest muestra esto solo para visitantes no logueados --}}
                @guest
                    {{-- Botón de login normal --}}
                    <a href="{{ route('login') }}" class="px-5 py-1.5 bg-blue-600 text-white rounded text-sm mb-4">{{ __('Login') }}</a>
                    
                    {{-- ========================================================
                         BOTONES DE DEMO RÁPIDO (Solo desarrollo)
                         Permiten saltar el login y entrar directamente con un rol
                         ⚠️ ELIMINAR ANTES DE PRODUCCIÓN ⚠️
                         ======================================================== --}}
                    <div class="flex gap-2 mt-4 bg-white/10 p-2 rounded backdrop-blur-sm">
                        <span class="text-xs text-gray-300 uppercase font-bold py-1 mr-2 px-2">{{ __('Demo Login') }}:</span>
                        
                        {{-- Cada botón enlaza a /login-role/{rol} que loguea automáticamente --}}
                        <a href="{{ route('login.role', 'admin') }}" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded transition">Admin</a>
                        <a href="{{ route('login.role', 'teacher') }}" class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded transition">Teacher</a>
                        <a href="{{ route('login.role', 'student') }}" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded transition">Student</a>
                    </div>
                
                {{-- Contenido para usuarios ya logueados --}}
                @else
                    <a href="{{ route('dashboard') }}" class="px-5 py-1.5 bg-blue-600 text-white rounded text-sm">{{ __('Dashboard') }}</a>
                @endguest
            </div>
        </main>

        {{-- ================================================================
             PIE DE PÁGINA / FOOTER
             Copyright y enlaces a redes sociales
             ================================================================ --}}
        <footer class="bg-[#1e2a4a] text-white py-2">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                
                {{-- Copyright dinámico con el año actual --}}
                <div class="flex items-center gap-2">
                    <i class="fas fa-globe text-cyan-400 text-sm"></i>
                    {{-- date('Y') devuelve el año actual (2024, 2025, etc.) --}}
                    <span class="text-xs">Copyright &copy; {{ date('Y') }} - All right reserved</span>
                </div>
                
                {{-- Enlaces a redes sociales --}}
                <div class="flex gap-3">
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
        </footer>
    </body>
</html>
