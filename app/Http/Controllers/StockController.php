<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function __construct(private InventoryService $inventoryService)
    {
        $this->authorizeResource(Stock::class, 'stock');
    }

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
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $stock->update($request->validated());

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
        $this->authorize('update', $stock);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $stock->quantiteAct],
        ]);

        $this->inventoryService->deductStock($stock, $validated['quantity']);

        return redirect()
            ->route('stock.show', $stock)
            ->with('success', 'Stock déduit avec succès');
    }
}
