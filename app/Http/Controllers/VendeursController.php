<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use Illuminate\Http\Request;

class VendeursController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Vendeur::class, 'vendeur');
    }

    public function index()
    {
        $vendeurs = Vendeur::paginate(15);
        return view('vendeurs.index', compact('vendeurs'));
    }

    public function create()
    {
        return view('vendeurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_vend'    => 'required|string|max:25',
            'prenom_vend' => 'required|string|max:25',
            'tel_vend'    => 'required|string|max:25',
            'farm_vend'   => 'nullable|string|max:25',
        ]);

        Vendeur::create($validated);

        return redirect()->route('vendeurs.index')->with('success', 'Vendeur ajouté avec succès.');
    }

    public function show(Vendeur $vendeur)
    {
        return view('vendeurs.show', compact('vendeur'));
    }

    public function edit(Vendeur $vendeur)
    {
        return view('vendeurs.edit', compact('vendeur'));
    }

    public function update(Request $request, Vendeur $vendeur)
    {
        $validated = $request->validate([
            'nom_vend'    => 'required|string|max:25',
            'prenom_vend' => 'required|string|max:25',
            'tel_vend'    => 'required|string|max:25',
            'farm_vend'   => 'nullable|string|max:25',
        ]);

        $vendeur->update($validated);

        return redirect()->route('vendeurs.index')->with('success', 'Vendeur mis à jour avec succès.');
    }

    public function destroy(Vendeur $vendeur)
    {
        $vendeur->delete();
        return redirect()->route('vendeurs.index')->with('success', 'Vendeur supprimé avec succès.');
    }
}
