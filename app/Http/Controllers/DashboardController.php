<?php

namespace App\Http\Controllers;

use App\Models\Bovin;
use App\Models\Stock;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeBovins = Bovin::active()->count();
        $soldBovins = Bovin::sold()->count();
        $deadBovins = Bovin::dead()->count();
        $lowStockCount = Stock::lowStock()->count();

        return view('dashboard', [
            'activeBovins' => $activeBovins,
            'soldBovins' => $soldBovins,
            'deadBovins' => $deadBovins,
            'lowStockCount' => $lowStockCount,
        ]);
    }
}
