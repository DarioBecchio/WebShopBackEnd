<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        $claims = Claim::when($request->search, fn($q,$s) => $q->where('label','like',"%$s%"))
            ->orderBy('label')->paginate(25)->withQueryString();

        return view('claims.index', compact('claims'));
    }

    public function create()
    {
        return view('claims.form', ['claim' => new Claim]);
    }

    public function store(Request $request)
    {
        Claim::create($request->validate([
            'code'     => 'required|string|max:64|unique:claims',
            'label'    => 'required|string|max:255',
            'category' => 'nullable|string|max:32',
        ]));
        return redirect()->route('claims.index')->with('success','Claim creato.');
    }

    public function edit(Claim $claim)
    {
        return view('claims.form', compact('claim'));
    }

    public function update(Request $request, Claim $claim)
    {
        $claim->update($request->validate([
            'code'     => 'required|string|max:64|unique:claims,code,'.$claim->id,
            'label'    => 'required|string|max:255',
            'category' => 'nullable|string|max:32',
        ]));
        return redirect()->route('claims.index')->with('success','Claim aggiornato.');
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->route('claims.index')->with('success','Claim eliminato.');
    }
}