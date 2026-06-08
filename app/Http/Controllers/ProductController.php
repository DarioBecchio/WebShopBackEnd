<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SkinType;
use App\Models\ProductLine;
use App\Models\Claim;
use App\Models\Certification;
use App\Models\SkinConcern;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['brand', 'category', 'translations'])
            ->when($request->search, fn($q, $s) =>
                $q->where('sku', 'like', "%$s%")
                  ->orWhereHas('translations', fn($q) => $q->where('name', 'like', "%$s%"))
            )
            ->when($request->brand_id, fn($q, $b) => $q->where('brand_id', $b))
            ->when($request->category_id, fn($q, $c) => $q->where('category_id', $c))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $brands     = Brand::orderBy('name')->pluck('name', 'id');
        $categories = Category::orderBy('name')->pluck('name', 'id');

        return view('products.index', compact('products', 'brands', 'categories'));
    }

    public function create()
    {
        return view('products.form', $this->formData(new Product));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku'             => 'required|string|max:255|unique:products',
            'brand_id'        => 'required|exists:brands,id',
            'category_id'     => 'required|exists:categories,id',
            'product_line_id' => 'nullable|exists:product_lines,id',
            'skin_type_id'    => 'nullable|exists:skin_types,id',
            'is_active'       => 'boolean',
            'launched_at'     => 'nullable|date',
        ]);
        $data['slug'] = Str::slug($data['sku'] . '-' . time());

        $product = Product::create($data);
        $this->syncRelations($product, $request);
        $this->syncTranslation($product, $request);

        return redirect()->route('products.index')->with('success', 'Prodotto creato con successo.');
    }

    public function edit(Product $product)
    {
        $product->load(['claims', 'certifications', 'skinConcerns', 'translations']);
        return view('products.form', $this->formData($product));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'sku'             => 'required|string|max:255|unique:products,sku,' . $product->id,
            'brand_id'        => 'required|exists:brands,id',
            'category_id'     => 'required|exists:categories,id',
            'product_line_id' => 'nullable|exists:product_lines,id',
            'skin_type_id'    => 'nullable|exists:skin_types,id',
            'is_active'       => 'boolean',
            'launched_at'     => 'nullable|date',
        ]);

        $product->update($data);
        $this->syncRelations($product, $request);
        $this->syncTranslation($product, $request);

        return redirect()->route('products.index')->with('success', 'Prodotto aggiornato.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Prodotto eliminato.');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function formData(Product $product): array
    {
        return [
            'product'      => $product,
            'brands'       => Brand::orderBy('name')->pluck('name', 'id'),
            'categories'   => Category::orderBy('name')->pluck('name', 'id'),
            'skinTypes'    => SkinType::orderBy('label')->pluck('label', 'id'),
            'productLines' => ProductLine::orderBy('name')->pluck('name', 'id'),
            'allClaims'    => Claim::orderBy('label')->get(),
            'allCerts'     => Certification::orderBy('name')->get(),
            'allConcerns'  => SkinConcern::orderBy('label')->get(),
        ];
    }

    private function syncRelations(Product $product, Request $request): void
    {
        $product->claims()->sync($request->input('claim_ids', []));
        $product->certifications()->sync($request->input('certification_ids', []));
        $product->skinConcerns()->sync($request->input('skin_concern_ids', []));
    }

    private function syncTranslation(Product $product, Request $request): void
    {
        if ($request->filled('trans_name')) {
            ProductTranslation::updateOrCreate(
                ['product_id' => $product->id, 'locale' => 'it'],
                [
                    'name'              => $request->trans_name,
                    'description'       => $request->trans_description,
                    'short_description' => $request->trans_short_description,
                    'how_to_use'        => $request->trans_how_to_use,
                ]
            );
        }
    }
}