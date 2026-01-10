{{-- 
    Vista: create.blade.php
    Propósito: Formulario para crear un nuevo alumno.
    Funcionalidad:
        - Formulario HTML enviado por POST a la ruta 'alumnos.store'.
        - Directiva @csrf para protección contra ataques CSRF.
        - Función old('campo') para mantener los datos si la validación falla.
        - Directiva @error para mostrar mensajes de validación específicos por campo.
--}}
<x-app-layout>
    <!-- Sub-menu -->
    <div class="bg-[#0891b2] -mt-4 mb-4">
        <div class="max-w-7xl mx-auto px-4 py-2 flex gap-2">
            <a href="{{ route('alumnos.index') }}" class="px-3 py-1 bg-orange-500 text-white text-xs rounded">
                {{ __('Back') }}
            </a>
        </div>
    </div>

    <div class="max-w-xl mx-auto px-4">
        <h2 class="text-xl font-bold mb-4">{{ __('New Student') }}</h2>
        
        <form action="{{ route('alumnos.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm mb-1">{{ __('Name') }} *</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" 
                       class="w-full px-3 py-2 border rounded @error('nombre') border-red-500 @enderror" required>
                @error('nombre')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">{{ __('Surname') }} *</label>
                <input type="text" name="apellidos" value="{{ old('apellidos') }}" 
                       class="w-full px-3 py-2 border rounded @error('apellidos') border-red-500 @enderror" required>
                @error('apellidos')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">{{ __('Email') }} *</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-3 py-2 border rounded @error('email') border-red-500 @enderror" required>
                @error('email')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">{{ __('DNI') }} *</label>
                <input type="text" name="dni" value="{{ old('dni') }}" maxlength="9"
                       class="w-full px-3 py-2 border rounded @error('dni') border-red-500 @enderror" required>
                @error('dni')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">{{ __('Date of Birth') }} *</label>
                <input type="date" name="f_nac" value="{{ old('f_nac') }}" 
                       class="w-full px-3 py-2 border rounded @error('f_nac') border-red-500 @enderror" required>
                @error('f_nac')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">{{ __('Save') }}</button>
                <a href="{{ route('alumnos.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
