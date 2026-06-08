<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $ingredients = Ingredient::query()
            ->when($request->search, fn($q,$s) =>
                $q->where('inci_name','like',"%$s%")
                  ->orWhere('common_name','like',"%$s%")
            )
            ->orderBy('inci_name')
            ->paginate(25)->withQueryString();

        return view('ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.form', ['ingredient' => new Ingredient]);
    }

    public function store(Request $request)
    {
        Ingredient::create($request->validate([
            'inci_name'              => 'required|string|max:255|unique:ingredients',
            'common_name'            => 'nullable|string|max:255',
            'function_description'   => 'nullable|string',
            'is_allergen'            => 'boolean',
            'is_endocrine_disruptor' => 'boolean',
        ]));
        return redirect()->route('ingredients.index')->with('success','Ingrediente creato.');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.form', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $ingredient->update($request->validate([
            'inci_name'              => 'required|string|max:255|unique:ingredients,inci_name,'.$ingredient->id,
            'common_name'            => 'nullable|string|max:255',
            'function_description'   => 'nullable|string',
            'is_allergen'            => 'boolean',
            'is_endocrine_disruptor' => 'boolean',
        ]));
        return redirect()->route('ingredients.index')->with('success','Ingrediente aggiornato.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredients.index')->with('success','Ingrediente eliminato.');
    }
}