<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $brand->exists ? 'Modifica Brand' : 'Nuovo Brand' }}
        </h2>
    </x-slot>

    <div class="max-w-2xl">
        <a href="{{ route('brands.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 mb-6 inline-block">
            ← Torna alla lista
        </a>

        <div class="bg-white rounded-xl border border-gray-200 p-8">
            <form method="POST"
                  action="{{ $brand->exists ? route('brands.update', $brand) : route('brands.store') }}">
                @csrf
                @if($brand->exists) @method('PUT') @endif

                <div class="grid grid-cols-2 gap-6">

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                        <input type="text" name="name" value="{{ old('name', $brand->name) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-300
                                      @error('name') border-red-400 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Codice paese (es. IT, FR)</label>
                        <input type="text" name="country_code" maxlength="2"
                               value="{{ old('country_code', $brand->country_code) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sito Web</label>
                        <input type="url" name="website_url"
                               value="{{ old('website_url', $brand->website_url) }}"
                               placeholder="https://..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descrizione</label>
                        <textarea name="description" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">{{ old('description', $brand->description) }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_cruelty_free" value="0">
                        <input type="checkbox" name="is_cruelty_free" id="cruelty_free" value="1"
                               {{ old('is_cruelty_free', $brand->is_cruelty_free) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600">
                        <label for="cruelty_free" class="text-sm text-gray-700">Cruelty Free</label>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_vegan" value="0">
                        <input type="checkbox" name="is_vegan" id="is_vegan" value="1"
                               {{ old('is_vegan', $brand->is_vegan) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600">
                        <label for="is_vegan" class="text-sm text-gray-700">Vegan</label>
                    </div>

                </div>

                <div class="flex gap-3 mt-8 pt-6 border-t border-gray-100">
                    <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                        {{ $brand->exists ? 'Salva modifiche' : 'Crea Brand' }}
                    </button>
                    <a href="{{ route('brands.index') }}"
                       class="px-6 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>