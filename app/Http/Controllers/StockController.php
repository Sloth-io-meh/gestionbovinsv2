<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of stock items.
     */
    public function index(Request $request)
    {
        $query = Stock::query();

        // Filter by status
        if ($request->has('status') && $request->status === 'low') {
            $query = $query->lowStock();
        } elseif ($request->has('status') && $request->status === 'expired') {
            $query = $query->expired();
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query = $query->where('libelle_st', 'like', '%' . $request->search . '%');
        }

        $stock = $query->paginate(20);

        return view('stock.index', compact('stock'));
    }

    /**
     * Show the form for creating a new stock item.
     */
    public function create()
    {
        return view('stock.create');
    }

    /**
     * Store a newly created stock item in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $item = Stock::create($request->validated());

        return redirect()
            ->route('stock.show', $item)
            ->with('success', 'Élément de stock ajouté avec succès');
    }

    /**
     * Display the specified stock item.
     */
    public function show(Stock $stock)
    {
        return view('stock.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified stock item.
     */
    public function edit(Stock $stock)
    {
        return view('stock.edit', compact('stock'));
    }

    /**
     * Update the specified stock item in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'libelle_st' => ['sometimes', 'string', 'max:255'],
            'description_s' => ['sometimes', 'string', 'max:1000'],
            'quantite_s' => ['sometimes', 'integer', 'min:1'],
            'quantiteAct' => ['sometimes', 'integer', 'min:0'],
            'prix_s' => ['sometimes', 'numeric', 'min:0'],
            'dateexp_s' => ['sometimes', 'date'],
        ]);

        $stock->update($validated);

        return redirect()
            ->route('stock.show', $stock)
            ->with('success', 'Élément de stock mis à jour');
    }

    /**
     * Remove the specified stock item from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()
            ->route('stock.index')
            ->with('success', 'Élément de stock supprimé');
    }

    /**
     * Deduct stock quantity.
     */
    public function deduct(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $stock->quantiteAct],
        ]);

        $stock->decrement('quantiteAct', $validated['quantity']);

        return redirect()
            ->route('stock.show', $stock)
            ->with('success', 'Stock déduit avec succès');
    }
}
