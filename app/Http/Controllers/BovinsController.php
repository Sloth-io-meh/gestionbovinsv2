<?php

namespace App\Http\Controllers;

use App\Models\Bovin;
use App\Models\Etable;
use App\Models\Vendeur;
use App\Models\Quarantaine;
use App\Http\Requests\StoreBovinRequest;
use App\Http\Requests\UpdateBovinRequest;
use Illuminate\Http\Request;

class BovinsController extends Controller
{
    /**
     * Display a listing of bovins.
     */
    public function index(Request $request)
    {
        $query = Bovin::with(['etable', 'vendeur', 'quarantaine']);

        // Filter by status
        if ($request->has('status') && $request->status === 'active') {
            $query = $query->active();
        } elseif ($request->has('status') && $request->status === 'sold') {
            $query = $query->sold();
        } elseif ($request->has('status') && $request->status === 'dead') {
            $query = $query->dead();
        }

        // Filter by farm
        if ($request->has('etab') && $request->etab) {
            $query = $query->where('id_etab', $request->etab);
        }

        // Sort
        $bovins = $query->paginate(15);
        $etables = Etable::all();

        return view('bovins.index', compact('bovins', 'etables'));
    }

    /**
     * Show the form for creating a new bovin.
     */
    public function create()
    {
        $etables = Etable::all();
        $vendeurs = Vendeur::all();
        $quarantaines = Quarantaine::all();

        return view('bovins.create', compact('etables', 'vendeurs', 'quarantaines'));
    }

    /**
     * Store a newly created bovin in storage.
     */
    public function store(StoreBovinRequest $request)
    {
        $bovin = Bovin::create($request->validated());

        return redirect()
            ->route('bovins.show', $bovin)
            ->with('success', 'Animal ajouté avec succès');
    }

    /**
     * Display the specified bovin.
     */
    public function show(Bovin $bovin)
    {
        $bovin = $bovin->load(['etable', 'vendeur', 'quarantaine', 'nourriture', 'medicsconsumed', 'visites']);

        return view('bovins.show', compact('bovin'));
    }

    /**
     * Show the form for editing the specified bovin.
     */
    public function edit(Bovin $bovin)
    {
        $etables = Etable::all();
        $vendeurs = Vendeur::all();
        $quarantaines = Quarantaine::all();

        return view('bovins.edit', compact('bovin', 'etables', 'vendeurs', 'quarantaines'));
    }

    /**
     * Update the specified bovin in storage.
     */
    public function update(UpdateBovinRequest $request, Bovin $bovin)
    {
        $bovin->update($request->validated());

        return redirect()
            ->route('bovins.show', $bovin)
            ->with('success', 'Animal mis à jour avec succès');
    }

    /**
     * Remove the specified bovin from storage.
     */
    public function destroy(Bovin $bovin)
    {
        $bovin->delete();

        return redirect()
            ->route('bovins.index')
            ->with('success', 'Animal supprimé avec succès');
    }

    /**
     * Mark bovin as sold.
     */
    public function markSold(Request $request, Bovin $bovin)
    {
        $validated = $request->validate([
            'prixavente' => ['required', 'numeric', 'min:0'],
            'poidvente' => ['required', 'numeric', 'min:0'],
            'lieuvente' => ['required', 'string', 'max:255'],
            'datevente' => ['required', 'date'],
        ]);

        $bovin->update([
            ...$validated,
            'vendu' => true,
        ]);

        return redirect()
            ->route('bovins.show', $bovin)
            ->with('success', 'Animal marqué comme vendu');
    }

    /**
     * Mark bovin as dead.
     */
    public function markDead(Request $request, Bovin $bovin)
    {
        $validated = $request->validate([
            'datemort' => ['required', 'date'],
        ]);

        $bovin->update([
            ...$validated,
            'mort' => true,
        ]);

        return redirect()
            ->route('bovins.show', $bovin)
            ->with('success', 'Animal marqué comme mort');
    }

    /**
     * Update current weight.
     */
    public function updateWeight(Request $request, Bovin $bovin)
    {
        $validated = $request->validate([
            'poidAct' => ['required', 'numeric', 'min:0'],
        ]);

        $bovin->update($validated);

        return redirect()
            ->route('bovins.show', $bovin)
            ->with('success', 'Poids mis à jour');
    }
}
