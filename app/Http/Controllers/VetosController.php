<?php

namespace App\Http\Controllers;

use App\Models\Veto;
use Illuminate\Http\Request;

class VetosController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Veto::class, 'veto');
    }

    public function index()
    {
        $vetos = Veto::paginate(15);
        return view('vetos.index', compact('vetos'));
    }

    public function create()
    {
        return view('vetos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_vet'     => 'required|string|max:25|unique:vetos,id_vet',
            'nom_vet'    => 'required|string|max:25',
            'prenom_vet' => 'required|string|max:25',
            'tel_vet'    => 'required|string|max:25',
        ]);

        Veto::create($validated);

        return redirect()->route('vetos.index')->with('success', 'Vétérinaire ajouté avec succès.');
    }

    public function show(Veto $veto)
    {
        return view('vetos.show', compact('veto'));
    }

    public function edit(Veto $veto)
    {
        return view('vetos.edit', compact('veto'));
    }

    public function update(Request $request, Veto $veto)
    {
        $validated = $request->validate([
            'nom_vet'    => 'required|string|max:25',
            'prenom_vet' => 'required|string|max:25',
            'tel_vet'    => 'required|string|max:25',
        ]);

        $veto->update($validated);

        return redirect()->route('vetos.index')->with('success', 'Vétérinaire mis à jour avec succès.');
    }

    public function destroy(Veto $veto)
    {
        $veto->delete();
        return redirect()->route('vetos.index')->with('success', 'Vétérinaire supprimé avec succès.');
    }
}
