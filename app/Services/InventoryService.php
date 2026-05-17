<?php

namespace App\Services;

use App\Models\Meds;
use App\Models\Stock;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    public function deductStock(Stock $stock, int $quantity): void
    {
        if ($quantity > $stock->quantiteAct) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity exceeds available stock.',
            ]);
        }

        $stock->decrement('quantiteAct', $quantity);
    }

    public function deductMeds(Meds $meds, int $quantity): void
    {
        if ($quantity > $meds->quantite_med) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity exceeds available medicine stock.',
            ]);
        }

        $meds->decrement('quantite_med', $quantity);
    }
}
