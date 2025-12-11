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
        <!-- Header oscuro azul marino -->
        <header class="bg-[#1e2a4a] text-white py-2">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <!-- Logo MRW Developer -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <svg class="h-14 w-20" viewBox="0 0 100 60" fill="none">
                            <ellipse cx="50" cy="28" rx="42" ry="22" fill="#FF6B35"/>
                            <text x="18" y="26" fill="#1e2a4a" font-size="11" font-weight="bold">MRW</text>
                            <path d="M12 38 Q50 58 88 38" stroke="#9333EA" stroke-width="5" fill="none"/>
                            <text x="22" y="52" fill="#9333EA" font-size="9" font-style="italic">Developer</text>
                        </svg>
                    </a>
                </div>
                
                <!-- Titulo centrado con nombre de usuario -->
                <div class="text-3xl font-bold tracking-wide">
                    SCHOOL MANAGEMENT
                    <span class="ml-2 text-base font-normal">{{ Auth::user()->name }}</span>
                </div>
                
                <!-- Botones derecha -->
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-1 bg-gray-600 rounded text-sm">
                            Logout
                        </button>
                    </form>
                    <span class="ml-2 text-green-400">Enghis</span>
                    <a href="{{ route('lang.switch', app()->getLocale() == 'es' ? 'en' : 'es') }}" class="flex items-center">
                        <img src="https://flagcdn.com/w40/gb.png" alt="EN" class="h-3 w-5 object-cover">
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
