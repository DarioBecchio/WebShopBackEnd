<?php

namespace App\Http\Controllers;

use App\Models\{Shade, ShadeFamily, Finish};
use Illuminate\Http\Request;

class ShadeController extends Controller
{
    public function index(Request $request)
    {
        $shades = Shade::with(['family','finish'])
            ->when($request->search, fn($q,$s) => $q->where('name','like',"%$s%"))
            ->orderBy('name')->paginate(25)->withQueryString();

        return view('shades.index', compact('shades'));
    }

    public function create()
    {
        return view('shades.form', $this->formData(new Shade));
    }

    public function store(Request $request)
    {
        Shade::create($this->validated($request));
        return redirect()->route('shades.index')->with('success','Tonalità creata.');
    }

    public function edit(Shade $shade)
    {
        return view('shades.form', $this->formData($shade));
    }

    public function update(Request $request, Shade $shade)
    {
        $shade->update($this->validated($request));
        return redirect()->route('shades.index')->with('success','Tonalità aggiornata.');
    }

    public function destroy(Shade $shade)
    {
        $shade->delete();
        return redirect()->route('shades.index')->with('success','Tonalità eliminata.');
    }

    private function formData(Shade $shade): array
    {
        return [
            'shade'    => $shade,
            'families' => ShadeFamily::orderBy('name')->pluck('name','id'),
            'finishes' => Finish::orderBy('label')->pluck('label','id'),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'            => 'required|string|max:255',
            'hex_color'       => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'shade_family_id' => 'required|exists:shade_families,id',
            'finish_id'       => 'nullable|exists:finishes,id',
        ]);
    }
}