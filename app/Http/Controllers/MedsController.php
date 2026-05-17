<?php

namespace App\Http\Controllers;

use App\Models\Meds;
use App\Http\Requests\StoreMedsRequest;
use App\Http\Requests\UpdateMedsRequest;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class MedsController extends Controller
{
    public function __construct(private InventoryService $inventoryService)
    {
        $this->authorizeResource(Meds::class, 'meds');
    }

    /**
     * Display a listing of medicines.
     */
    public function index(Request $request)
    {
        $query = Meds::query();

        // Filter by status
        if ($request->has('status') && $request->status === 'low') {
            $query = $query->lowStock();
        } elseif ($request->has('status') && $request->status === 'expired') {
            $query = $query->expired();
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query = $query->where('libelle', 'like', '%' . $request->search . '%');
        }

        $meds = $query->paginate(20);

        return view('meds.index', compact('meds'));
    }

    /**
     * Show the form for creating a new medicine.
     */
    public function create()
    {
        return view('meds.create');
    }

    /**
     * Store a newly created medicine in storage.
     */
    public function store(StoreMedsRequest $request)
    {
        $med = Meds::create($request->validated());

        return redirect()
            ->route('meds.show', $med)
            ->with('success', 'Médicament ajouté avec succès');
    }

    /**
     * Display the specified medicine.
     */
    public function show(Meds $meds)
    {
        $meds = $meds->load('medicsconsumed');

        return view('meds.show', compact('meds'));
    }

    /**
     * Show the form for editing the specified medicine.
     */
    public function edit(Meds $meds)
    {
        return view('meds.edit', compact('meds'));
    }

    /**
     * Update the specified medicine in storage.
     */
    public function update(UpdateMedsRequest $request, Meds $meds)
    {
        $meds->update($request->validated());

        return redirect()
            ->route('meds.show', $meds)
            ->with('success', 'Médicament mis à jour');
    }

    /**
     * Remove the specified medicine from storage.
     */
    public function destroy(Meds $meds)
    {
        $meds->delete();

        return redirect()
            ->route('meds.index')
            ->with('success', 'Médicament supprimé');
    }

    /**
     * Deduct medicine quantity.
     */
    public function deduct(Request $request, Meds $meds)
    {
        $this->authorize('update', $meds);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $meds->quantite_med],
        ]);

        $this->inventoryService->deductMeds($meds, $validated['quantity']);

        return redirect()
            ->route('meds.show', $meds)
            ->with('success', 'Quantité déduite');
    }
}
