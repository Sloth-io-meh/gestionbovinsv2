<?php

namespace App\Http\Controllers;

use App\Models\Etable;
use Illuminate\Http\Request;

class EtablesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Etable::class, 'etable');
    }

    public function index()
    {
        $etables = Etable::paginate(15);
        return view('etables.index', compact('etables'));
    }

    public function create()
    {
        return view('etables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
        ]);

        Etable::create($validated);

        return redirect()->route('etables.index')->with('success', 'Étable ajoutée avec succès.');
    }

    public function show(Etable $etable)
    {
        return view('etables.show', compact('etable'));
    }

    public function edit(Etable $etable)
    {
        return view('etables.edit', compact('etable'));
    }

    public function update(Request $request, Etable $etable)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
        ]);

        $etable->update($validated);

        return redirect()->route('etables.index')->with('success', 'Étable mise à jour avec succès.');
    }

    public function destroy(Etable $etable)
    {
        $etable->delete();
        return redirect()->route('etables.index')->with('success', 'Étable supprimée avec succès.');
    }
}
