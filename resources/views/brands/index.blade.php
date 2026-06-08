<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Brand</h2>
            <a href="{{ route('brands.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                + Nuovo Brand
            </a>
        </div>
    </x-slot>

    {{-- Ricerca --}}
    <div class="mb-4">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cerca brand..."
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <button class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">Cerca</button>
            @if(request('search'))
                <a href="{{ route('brands.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">✕ Reset</a>
            @endif
        </form>
    </div>

    {{-- Tabella --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="px-6 py-3 text-left">Nome</th>
                    <th class="px-6 py-3 text-left">Paese</th>
                    <th class="px-6 py-3 text-left">Cruelty Free</th>
                    <th class="px-6 py-3 text-left">Vegan</th>
                    <th class="px-6 py-3 text-left">Sito Web</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($brands as $brand)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $brand->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $brand->country_code ?? '—' }}</td>
                    <td class="px-6 py-4">
                        @if($brand->is_cruelty_free)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">✓ Sì</span>
                        @else
                            <span class="text-gray-400 text-xs">No</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($brand->is_vegan)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">✓ Sì</span>
                        @else
                            <span class="text-gray-400 text-xs">No</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($brand->website_url)
                            <a href="{{ $brand->website_url }}" target="_blank"
                               class="text-indigo-600 hover:underline text-xs">
                                {{ parse_url($brand->website_url, PHP_URL_HOST) }}
                            </a>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex gap-3 justify-end">
                            <a href="{{ route('brands.edit', $brand) }}"
                               class="text-indigo-600 hover:underline text-xs">Modifica</a>
                            <form method="POST" action="{{ route('brands.destroy', $brand) }}"
                                  onsubmit="return confirm('Eliminare questo brand?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs">Elimina</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">Nessun brand trovato.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($brands->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $brands->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
