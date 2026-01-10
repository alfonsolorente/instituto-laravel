<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Barra negra superior -->
        <div class="h-12 bg-[#1a1a2a] w-full flex justify-end items-center px-4">
            <!-- Selector de Idiomas (Dropdown) -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="flex items-center text-sm font-medium text-gray-300 hover:text-white transition duration-150 ease-in-out focus:outline-none">
                    <div>
                        @switch(app()->getLocale())
                            @case('es') <img src="https://flagcdn.com/w40/es.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> Español @break
                            @case('en') <img src="https://flagcdn.com/w40/gb.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> English @break
                            @case('fr') <img src="https://flagcdn.com/w40/fr.png" class="h-4 w-6 object-cover rounded shadow-sm inline-block mr-1"> Français @break
                        @endswitch
                    </div>
                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

                <div x-show="open" 
                     style="display: none;"
                     class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <a href="{{ route('lang.switch', 'es') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" role="menuitem">
                            <img src="https://flagcdn.com/w40/es.png" class="h-3 w-5 object-cover mr-2"> Español
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" role="menuitem">
                            <img src="https://flagcdn.com/w40/gb.png" class="h-3 w-5 object-cover mr-2"> English
                        </a>
                        <a href="{{ route('lang.switch', 'fr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center" role="menuitem">
                            <img src="https://flagcdn.com/w40/fr.png" class="h-3 w-5 object-cover mr-2"> Français
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Linea cyan/turquesa -->
        <div class="h-1.5 bg-[#06b6d4] w-full"></div>
        
        <!-- Contenido principal con fondo gris azulado -->
        <div class="min-h-[calc(100vh-54px)] flex flex-col justify-center items-center bg-[#c8d4e0]">
            <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-md overflow-hidden rounded">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
