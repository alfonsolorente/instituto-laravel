{{-- 
    Vista: show.blade.php
    Propósito: Mostrar los detalles completos de un alumno específico.
    Funcionalidad:
        - Muestra la información del alumno (solo lectura).
        - Botones para Editar o Eliminar el registro actual.
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
        <h2 class="text-xl font-bold mb-4">{{ __('Student Details') }}</h2>
        
        <div class="bg-gray-50 p-4 rounded space-y-3">
            <div>
                <span class="text-gray-500 text-sm">{{ __('Name') }}:</span>
                <p class="font-medium">{{ $alumno->nombre }}</p>
            </div>
            <div>
                <span class="text-gray-500 text-sm">{{ __('Surname') }}:</span>
                <p class="font-medium">{{ $alumno->apellidos }}</p>
            </div>
            <div>
                <span class="text-gray-500 text-sm">{{ __('Email') }}:</span>
                <p class="font-medium">{{ $alumno->email }}</p>
            </div>
            <div>
                <span class="text-gray-500 text-sm">{{ __('DNI') }}:</span>
                <p class="font-medium">{{ $alumno->dni }}</p>
            </div>
            <div>
                <span class="text-gray-500 text-sm">{{ __('Date of Birth') }}:</span>
                <p class="font-medium">{{ $alumno->f_nac->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="mt-4 flex gap-2">
            <a href="{{ route('alumnos.edit', $alumno) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">{{ __('Edit') }}</a>
            <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Delete Student?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>
</x-app-layout>
