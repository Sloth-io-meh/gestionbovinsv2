<?php

namespace App\Http\Controllers;

use App\Models\Quarantaine;
use Illuminate\Http\Request;

class QuarantainesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Quarantaine::class, 'quarantaine');
    }

    public function index()
    {
        $quarantaines = Quarantaine::paginate(15);
        return view('quarantaines.index', compact('quarantaines'));
    }

    public function create()
    {
        return view('quarantaines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:100',
        ]);

        Quarantaine::create($validated);

        return redirect()->route('quarantaines.index')->with('success', 'Statut de quarantaine ajouté avec succès.');
    }

    public function show(Quarantaine $quarantaine)
    {
        return view('quarantaines.show', compact('quarantaine'));
    }

    public function edit(Quarantaine $quarantaine)
    {
        return view('quarantaines.edit', compact('quarantaine'));
    }

    public function update(Request $request, Quarantaine $quarantaine)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:100',
        ]);

        $quarantaine->update($validated);

        return redirect()->route('quarantaines.index')->with('success', 'Statut de quarantaine mis à jour avec succès.');
    }

    public function destroy(Quarantaine $quarantaine)
    {
        $quarantaine->delete();
        return redirect()->route('quarantaines.index')->with('success', 'Statut de quarantaine supprimé avec succès.');
    }
}
