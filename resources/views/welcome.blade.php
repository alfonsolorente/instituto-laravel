<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'School Management') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased m-0 p-0">
        <!-- Header oscuro azul marino -->
        <header class="bg-[#1e2a4a] text-white py-2">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto">
                    </a>
                </div>
                
                <!-- Titulo centrado -->
                <div class="text-3xl font-bold tracking-wide">
                    SCHOOL MANAGEMENT
                </div>
                
                <!-- Botones derecha -->
                <div class="flex items-center gap-2">
                    @auth
                        <span class="mr-2">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-1 border border-gray-400 rounded text-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-1 border border-gray-400 rounded text-sm">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-1 border border-gray-400 rounded text-sm">
                            Register
                        </a>
                    @endauth
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
                <a href="#about" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">About</a>
                <a href="#contacta" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">Contacta</a>
                <a href="#noticias" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">Noticias</a>
                <a href="#referencias" class="px-3 py-1 bg-[#1e3a5f] text-white text-xs rounded">Referencias</a>
            </div>
        </nav>

        <!-- Hero con imagen de fondo - calle con luces -->
        <main class="relative h-[420px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1476973422084-e0fa66ff9456?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="relative h-full flex flex-col items-center justify-center text-white text-center">
                <h1 class="text-5xl font-bold italic text-yellow-400 mb-0">Aprendiendo</h1>
                <h1 class="text-5xl font-bold italic text-yellow-400 mb-4">Laravel</h1>
                <p class="text-gray-300 text-sm mb-1">Aplicacion para aprender Laravel</p>
                <p class="text-gray-300 text-sm mb-4">Registrate para acceder a las opciones</p>
                @guest
                    <a href="{{ route('login') }}" class="px-5 py-1.5 bg-blue-600 text-white rounded text-sm">Login</a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-5 py-1.5 bg-blue-600 text-white rounded text-sm">Dashboard</a>
                @endguest
            </div>
        </main>

        <!-- Footer oscuro -->
        <footer class="bg-[#1e2a4a] text-white py-2">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i class="fas fa-globe text-cyan-400 text-sm"></i>
                    <span class="text-xs">Copyright &copy; {{ date('Y') }} - All right reserved</span>
                </div>
                <div class="flex gap-3">
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
        </footer>
    </body>
</html>
