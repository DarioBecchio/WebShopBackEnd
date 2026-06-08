<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Shade;
use App\Models\Size;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductVariantController extends Controller
{
    public function index(Request $request)
    {
        $variants = ProductVariant::with(['product.translations', 'shade', 'size'])
            ->when($request->search, fn($q, $s) => $q->where('sku', 'like', "%$s%"))
            ->when($request->product_id, fn($q, $p) => $q->where('product_id', $p))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $products = Product::with('translations')
            ->get()
            ->mapWithKeys(fn($p) => [$p->id => $p->translations->first()?->name ?? $p->sku]);

        return view('variants.index', compact('variants', 'products'));
    }

    public function create()
    {
        return view('variants.form', $this->formData(new ProductVariant));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'shade_id'   => 'nullable|exists:shades,id',
            'size_id'    => 'nullable|exists:sizes,id',
            'sku'        => 'required|string|max:255|unique:product_variants',
            'price'      => 'required|numeric|min:0',
            'currency'   => 'required|string|size:3',
            'stock_qty'  => 'required|integer|min:0',
            'is_default' => 'boolean',
        ]);

        $variant = ProductVariant::create($data);
        $this->syncIngredients($variant, $request);

        return redirect()->route('variants.index')->with('success', 'Variante creata.');
    }

    public function edit(ProductVariant $variant)
    {
        $variant->load('ingredients');
        return view('variants.form', $this->formData($variant));
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'shade_id'   => 'nullable|exists:shades,id',
            'size_id'    => 'nullable|exists:sizes,id',
            'sku'        => 'required|string|max:255|unique:product_variants,sku,' . $variant->id,
            'price'      => 'required|numeric|min:0',
            'currency'   => 'required|string|size:3',
            'stock_qty'  => 'required|integer|min:0',
            'is_default' => 'boolean',
        ]);

        $variant->update($data);
        $this->syncIngredients($variant, $request);

        return redirect()->route('variants.index')->with('success', 'Variante aggiornata.');
    }

    public function destroy(ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->route('variants.index')->with('success', 'Variante eliminata.');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function formData(ProductVariant $variant): array
    {
        return [
            'variant'     => $variant,
            'products'    => Product::with('translations')
                                ->get()
                                ->mapWithKeys(fn($p) => [$p->id => $p->translations->first()?->name ?? $p->sku]),
            'shades'      => Shade::orderBy('name')->pluck('name', 'id'),
            'sizes'       => Size::orderBy('amount')
                                ->get()
                                ->mapWithKeys(fn($s) => [$s->id => $s->display_label]),
            'ingredients' => Ingredient::orderBy('inci_name')->pluck('inci_name', 'id'),
        ];
    }

    private function syncIngredients(ProductVariant $variant, Request $request): void
    {
        $ids = $request->input('ingredient_ids', []);
        $sync = [];
        foreach ($ids as $pos => $id) {
            $sync[$id] = [
                'position'         => $pos + 1,
                'is_key_ingredient' => false,
            ];
        }
        $variant->ingredients()->sync($sync);
    }
}