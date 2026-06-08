<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('parent')
            ->when($request->search, fn($q,$s) => $q->where('name','like',"%$s%"))
            ->orderBy('depth')->orderBy('name')
            ->paginate(25)->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::orderBy('name')->pluck('name','id');
        return view('categories.form', ['category' => new Category, 'parents' => $parents]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $data['slug']  = Str::slug($data['name'].'-'.time());
        $data['depth'] = $data['parent_id']
            ? Category::find($data['parent_id'])->depth + 1
            : 0;
        Category::create($data);

        return redirect()->route('categories.index')->with('success','Categoria creata.');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id','!=',$category->id)->orderBy('name')->pluck('name','id');
        return view('categories.form', compact('category','parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $data['depth'] = $data['parent_id']
            ? Category::find($data['parent_id'])->depth + 1
            : 0;
        $category->update($data);

        return redirect()->route('categories.index')->with('success','Categoria aggiornata.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success','Categoria eliminata.');
    }
}