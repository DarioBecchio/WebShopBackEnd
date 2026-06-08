<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::query()
            ->when($request->search, fn($q,$s) => $q->where('name','like',"%$s%"))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.form', ['brand' => new Brand]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'country_code'    => 'nullable|string|max:2',
            'description'     => 'nullable|string',
            'website_url'     => 'nullable|url',
            'is_cruelty_free' => 'boolean',
            'is_vegan'        => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name'].'-'.time());
        Brand::create($data);

        return redirect()->route('brands.index')->with('success','Brand creato con successo.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.form', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'country_code'    => 'nullable|string|max:2',
            'description'     => 'nullable|string',
            'website_url'     => 'nullable|url',
            'is_cruelty_free' => 'boolean',
            'is_vegan'        => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name'].'-'.$brand->id);
        $brand->update($data);

        return redirect()->route('brands.index')->with('success','Brand aggiornato.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success','Brand eliminato.');
    }
}