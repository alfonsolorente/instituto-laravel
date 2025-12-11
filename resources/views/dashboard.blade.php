<x-app-layout>
    <div class="max-w-7xl mx-auto px-4">
        <!-- Tarjeta CRUD Alumnos -->
        <div class="w-64 rounded-lg overflow-hidden shadow-lg bg-gradient-to-br from-gray-500 to-gray-700">
            <div class="relative">
                <!-- Imagen de estudiantes cartoon -->
                <img src="https://img.freepik.com/free-vector/group-young-people-posing-photo_52683-18824.jpg" alt="Estudiantes" class="w-full h-36 object-cover opacity-80">
                
                <!-- Overlay con gradiente -->
                <div class="absolute inset-0 bg-gradient-to-t from-gray-800/90 via-gray-700/50 to-transparent"></div>
                
                <!-- Contenido sobre la imagen -->
                <div class="absolute bottom-0 left-0 right-0 p-3">
                    <h3 class="text-sm font-bold text-white">CRUD Alumnos!</h3>
                    <p class="text-xs text-gray-300 mb-2 leading-tight">Gestionamos Altas bajas actualizaciones<br>y borrado de una tabla de alumnos</p>
                    <a href="{{ route('alumnos.index') }}" class="inline-block px-4 py-1 bg-blue-600 text-white text-xs rounded">
                        Ver alumnos
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
