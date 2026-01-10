{{-- 
    Vista: edit.blade.php
    Propósito: Formulario para editar un alumno existente.
    Funcionalidad:
        - Mismo formulario que en create, pero con los campos rellenos con los datos actuales.
        - Directiva @method('PUT') para simular una petición PUT/PATCH requerida para actualizar.
        - Uso de old('campo', $valor_defecto) para mostrar el valor actual o el intento fallido anterior.
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
        <h2 class="text-xl font-bold mb-4">{{ __('Edit Student') }}</h2>
        
        <form action="{{ route('alumnos.update', $alumno) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm mb-1">{{ __('Name') }} *</label>
                <input type="text" name="nombre" value="{{ old('nombre', $alumno->nombre) }}" 
                       class="w-full px-3 py-2 border rounded @error('nombre') border-red-500 @enderror" required>
                @error('nombre')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">{{ __('Surname') }} *</label>
                <input type="text" name="apellidos" value="{{ old('apellidos', $alumno->apellidos) }}" 
                       class="w-full px-3 py-2 border rounded @error('apellidos') border-red-500 @enderror" required>
                @error('apellidos')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">{{ __('Email') }} *</label>
                <input type="email" name="email" value="{{ old('email', $alumno->email) }}" 
                       class="w-full px-3 py-2 border rounded @error('email') border-red-500 @enderror" required>
                @error('email')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">{{ __('DNI') }} *</label>
                <input type="text" name="dni" value="{{ old('dni', $alumno->dni) }}" maxlength="9"
                       class="w-full px-3 py-2 border rounded @error('dni') border-red-500 @enderror" required>
                @error('dni')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm mb-1">{{ __('Date of Birth') }} *</label>
                <input type="date" name="f_nac" value="{{ old('f_nac', $alumno->f_nac->format('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border rounded @error('f_nac') border-red-500 @enderror" required>
                @error('f_nac')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">{{ __('Update') }}</button>
                <a href="{{ route('alumnos.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
