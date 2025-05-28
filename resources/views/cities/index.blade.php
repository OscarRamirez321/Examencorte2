<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cities') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="mb-4 flex justify-end space-x-2"> {{-- Added space-x-2 for spacing --}}
            <a href="{{ route('cities.create') }}"
                class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                {{ __('Create City') }}
            </a>
            <a href="{{ route('cities.export.xls') }}"
                class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                Exportar XLS
            </a>
            <a href="{{ route('cities.export.csv') }}"
                class="inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                Exportar CSV
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($cities as $city)
                <div class="bg-white shadow-lg ring-1 ring-gray-200 rounded p-6 flex flex-col justify-between transition duration-200 hover:shadow-2xl hover:ring-blue-400 hover:scale-105">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $city->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $city->description }}</p>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('cities.edit', $city->id) }}"
                            class="text-indigo-600 hover:text-indigo-900 font-medium">
                            {{ __('Edit') }}
                        </a>
                        @if (request('delete') == $city->id)
                            <form action="{{ route('cities.destroy', $city->id) }}" method="POST" class="flex space-x-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    {{ __('Confirm Delete') }}
                                </button>
                                <a href="{{ route('cities.index') }}"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                    {{ __('Cancel') }}
                                </a>
                            </form>
                        @else
                            <a href="{{ route('cities.index', ['delete' => $city->id]) }}"
                                class="text-red-600 hover:text-red-900 font-medium">
                                {{ __('Delete') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $cities->links() }}
        </div>
    </div>
</x-app-layout>