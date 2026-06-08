<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index(Request $request)
    {
        $certifications = Certification::when($request->search, fn($q,$s) => $q->where('name','like',"%$s%"))
            ->orderBy('name')->paginate(25)->withQueryString();

        return view('certifications.index', compact('certifications'));
    }

    public function create()
    {
        return view('certifications.form', ['certification' => new Certification]);
    }

    public function store(Request $request)
    {
        Certification::create($request->validate([
            'code'         => 'required|string|max:32|unique:certifications',
            'name'         => 'required|string|max:255',
            'issuing_body' => 'nullable|string|max:255',
            'logo_url'     => 'nullable|url',
        ]));
        return redirect()->route('certifications.index')->with('success','Certificazione creata.');
    }

    public function edit(Certification $certification)
    {
        return view('certifications.form', compact('certification'));
    }

    public function update(Request $request, Certification $certification)
    {
        $certification->update($request->validate([
            'code'         => 'required|string|max:32|unique:certifications,code,'.$certification->id,
            'name'         => 'required|string|max:255',
            'issuing_body' => 'nullable|string|max:255',
            'logo_url'     => 'nullable|url',
        ]));
        return redirect()->route('certifications.index')->with('success','Certificazione aggiornata.');
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();
        return redirect()->route('certifications.index')->with('success','Certificazione eliminata.');
    }
}