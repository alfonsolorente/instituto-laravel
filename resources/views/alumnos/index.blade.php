<x-app-layout>
    <!-- Sub-menu verde/naranja sobre fondo cyan -->
    <div class="bg-[#0891b2] -mt-4 mb-4">
        <div class="max-w-7xl mx-auto px-4 py-2 flex gap-2">
            <a href="{{ route('alumnos.create') }}" class="px-3 py-1 bg-green-600 text-white text-xs rounded">
                Crear alumno
            </a>
            <a href="{{ route('dashboard') }}" class="px-3 py-1 bg-orange-500 text-white text-xs rounded">
                Volver
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla estilo mockup -->
        <table class="w-full">
            <thead>
                <tr class="border-b-2 border-[#0891b2]">
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">id</th>
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">nombre</th>
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">f_nac</th>
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">dni</th>
                    <th class="text-left py-2 px-2 text-gray-500 font-normal text-sm">email</th>
                    <th class="py-2 px-2 w-8"></th>
                    <th class="py-2 px-2 w-8"></th>
                    <th class="py-2 px-2 w-10"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 px-2 text-gray-700 text-sm">{{ $alumno->id }}</td>
                        <td class="py-3 px-2 text-gray-700 text-sm">{{ $alumno->nombre }} {{ $alumno->apellidos }}</td>
                        <td class="py-3 px-2 text-gray-700 text-sm">{{ $alumno->f_nac->format('Y-m-d') }}</td>
                        <td class="py-3 px-2 text-gray-700 text-sm">{{ $alumno->dni }}</td>
                        <td class="py-3 px-2">
                            <a href="mailto:{{ $alumno->email }}" class="text-cyan-600 text-sm">{{ $alumno->email }}</a>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <a href="{{ route('alumnos.edit', $alumno) }}" class="text-cyan-500">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar alumno?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-2 text-center">
                            <a href="{{ route('alumnos.show', $alumno) }}" class="text-gray-500 text-sm">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $alumnos->links() }}
        </div>
    </div>
</x-app-layout>
