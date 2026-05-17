<?php

namespace App\Http\Controllers;

use App\Models\Tansporteur;
use Illuminate\Http\Request;

class TansporteursController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Tansporteur::class, 'tansporteur');
    }

    public function index()
    {
        $tansporteurs = Tansporteur::paginate(15);
        return view('tansporteurs.index', compact('tansporteurs'));
    }

    public function create()
    {
        return view('tansporteurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cin_t' => 'required|string|max:10|unique:tansporteurs,cin_t',
            'nom'   => 'required|string|max:25',
            'prenom' => 'required|string|max:25',
            'tel'   => 'required|string|max:25',
        ]);

        Tansporteur::create($validated);

        return redirect()->route('tansporteurs.index')->with('success', 'Transporteur ajouté avec succès.');
    }

    public function show(Tansporteur $tansporteur)
    {
        return view('tansporteurs.show', compact('tansporteur'));
    }

    public function edit(Tansporteur $tansporteur)
    {
        return view('tansporteurs.edit', compact('tansporteur'));
    }

    public function update(Request $request, Tansporteur $tansporteur)
    {
        $validated = $request->validate([
            'cin_t'  => 'required|string|max:10|unique:tansporteurs,cin_t,' . $tansporteur->id_trans . ',id_trans',
            'nom'    => 'required|string|max:25',
            'prenom' => 'required|string|max:25',
            'tel'    => 'required|string|max:25',
        ]);

        $tansporteur->update($validated);

        return redirect()->route('tansporteurs.index')->with('success', 'Transporteur mis à jour avec succès.');
    }

    public function destroy(Tansporteur $tansporteur)
    {
        $tansporteur->delete();
        return redirect()->route('tansporteurs.index')->with('success', 'Transporteur supprimé avec succès.');
    }
}
