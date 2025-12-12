<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'School Management') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased m-0 p-0 bg-white">
        <!-- Header con gradiente cyan -->
        <header class="bg-gradient-to-r from-cyan-500 via-cyan-600 to-blue-700 text-white py-3">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
                    </a>
                </div>
                
                <!-- Titulo centrado con nombre de usuario -->
                <div class="flex items-center">
                    <span class="text-4xl font-bold tracking-wide">SCHOOL MANAGEMENT</span>
                    <span class="ml-4 text-lg">{{ Auth::user()->name }}</span>
                </div>
                
                <!-- Botones derecha -->
                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 bg-gray-700 hover:bg-gray-600 rounded text-sm">
                            Logout
                        </button>
                    </form>
                    <span class="ml-2 text-green-400 font-medium">Enghis</span>
                    <a href="{{ route('lang.switch', app()->getLocale() == 'es' ? 'en' : 'es') }}" class="flex items-center">
                        <img src="https://flagcdn.com/w40/gb.png" alt="EN" class="h-4 w-6 object-cover">
                    </a>
                </div>
            </div>
        </header>

        <!-- Menu navegacion cyan -->
        <nav class="bg-[#0891b2] py-2">
            <div class="max-w-7xl mx-auto px-4 flex gap-2">
                <a href="/#about" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">About</a>
                <a href="/#contacta" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">Contacta</a>
                <a href="/#noticias" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">Noticias</a>
                <a href="/#referencias" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">Referencias</a>
            </div>
        </nav>

        <!-- Contenido -->
        <main class="py-4">
            {{ $slot }}
        </main>
    </body>
</html>
