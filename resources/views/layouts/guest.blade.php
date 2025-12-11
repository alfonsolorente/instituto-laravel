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
        <div class="h-12 bg-[#1a1a2a] w-full"></div>
        
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
