<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use App\Models\Bovin;
use App\Models\Veto;
use App\Http\Requests\StoreVisiteRequest;
use App\Http\Requests\UpdateVisiteRequest;
use Illuminate\Http\Request;

class VisitesController extends Controller
{
    /**
     * Display a listing of visits.
     */
    public function index(Request $request)
    {
        $query = Visite::with(['bovin', 'veto']);

        // Filter by animal
        if ($request->has('bovin') && $request->bovin) {
            $query = $query->where('id_bov', $request->bovin);
        }

        // Filter by veterinarian
        if ($request->has('veto') && $request->veto) {
            $query = $query->where('id_vet', $request->veto);
        }

        // Search by description
        if ($request->has('search') && $request->search) {
            $query = $query->where('description_v', 'like', '%' . $request->search . '%');
        }

        $visites = $query->orderBy('datepres', 'desc')->paginate(15);
        $bovins = Bovin::active()->get();
        $vetos = Veto::all();

        return view('visites.index', compact('visites', 'bovins', 'vetos'));
    }

    /**
     * Show the form for creating a new visit.
     */
    public function create()
    {
        $bovins = Bovin::active()->get();
        $vetos = Veto::all();

        return view('visites.create', compact('bovins', 'vetos'));
    }

    /**
     * Store a newly created visit in storage.
     */
    public function store(StoreVisiteRequest $request)
    {
        $visite = Visite::create($request->validated());

        return redirect()
            ->route('visites.show', $visite)
            ->with('success', 'Visite vétérinaire enregistrée');
    }

    /**
     * Display the specified visit.
     */
    public function show(Visite $visite)
    {
        $visite = $visite->load(['bovin', 'veto']);

        return view('visites.show', compact('visite'));
    }

    /**
     * Show the form for editing the specified visit.
     */
    public function edit(Visite $visite)
    {
        $bovins = Bovin::all();
        $vetos = Veto::all();

        return view('visites.edit', compact('visite', 'bovins', 'vetos'));
    }

    /**
     * Update the specified visit in storage.
     */
    public function update(UpdateVisiteRequest $request, Visite $visite)
    {
        $visite->update($request->validated());

        return redirect()
            ->route('visites.show', $visite)
            ->with('success', 'Visite mise à jour');
    }

    /**
     * Remove the specified visit from storage.
     */
    public function destroy(Visite $visite)
    {
        $visite->delete();

        return redirect()
            ->route('visites.index')
            ->with('success', 'Visite supprimée');
    }
}
