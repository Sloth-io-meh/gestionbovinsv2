<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Tansporteur;
use Illuminate\Http\Request;

class VehiculesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Vehicule::class, 'vehicule');
    }

    public function index()
    {
        $vehicules = Vehicule::paginate(15);
        return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        $tansporteurs = Tansporteur::all();
        return view('vehicules.create', compact('tansporteurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Matricule' => 'required|string|max:25',
            'type'      => 'required|string|max:25',
            'id_trans'  => 'nullable|integer|exists:tansporteurs,id_trans',
        ]);

        Vehicule::create($validated);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule ajouté avec succès.');
    }

    public function show(Vehicule $vehicule)
    {
        return view('vehicules.show', compact('vehicule'));
    }

    public function edit(Vehicule $vehicule)
    {
        return view('vehicules.edit', compact('vehicule'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $validated = $request->validate([
            'Matricule' => 'required|string|max:25',
            'type'      => 'required|string|max:25',
        ]);

        $vehicule->update($validated);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule mis à jour avec succès.');
    }

    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();
        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé avec succès.');
    }
}
