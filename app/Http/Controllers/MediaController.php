<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Upload one or more immagini per una variante.
     */
    public function store(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096', // max 4MB per file
            'alt_text' => 'nullable|string|max:255',
        ], [
            'images.required' => 'Seleziona almeno un\'immagine da caricare.',
            'images.*.image' => 'Ogni file deve essere un\'immagine valida.',
            'images.*.mimes' => 'Formati ammessi: JPG, PNG, WEBP.',
            'images.*.max' => 'Ogni immagine non può superare i 4MB.',
        ]);

        $currentMax = $variant->media()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('variants/' . $variant->id, 'public');

            $variant->media()->create([
                'type' => 'image',
                'url' => Storage::url($path),
                'alt_text' => $validated['alt_text'] ?? null,
                'sort_order' => $currentMax + $index + 1,
            ]);
        }

        return back()->with('success', 'Immagini caricate con successo.');
    }

    /**
     * Elimina un singolo file media (record + file fisico).
     */
    public function destroy(Media $media)
    {
        // Ricava il path fisico dall'URL pubblico per eliminare il file dal disco
        $relativePath = str_replace('/storage/', '', parse_url($media->url, PHP_URL_PATH));
        Storage::disk('public')->delete($relativePath);

        $media->delete();

        return back()->with('success', 'Immagine eliminata.');
    }

    /**
     * Aggiorna l'ordine di visualizzazione (drag & drop opzionale).
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:media,id',
        ]);

        foreach ($validated['order'] as $position => $mediaId) {
            Media::where('id', $mediaId)->update(['sort_order' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }
}