<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Spending;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MoneyBoxController extends Controller
{
    public function index(Request $request): View
    {
        $salemoneys = Sale::orderBy('created_at', 'DESC')->get();
        $purchasemoneys = Purchase::orderBy('created_at', 'DESC')->get();
        $spendmoneys = Spending::orderBy('created_at', 'DESC')->get();
        $general_settings = GeneralSetting::all();

        $totalsalemoneys = collect($salemoneys)->sum('total_amount');
        $totalsaleduemoneys = collect($salemoneys)->sum('due');
        $totalpurchasemoneys = collect($purchasemoneys)->sum('total_amount');
        $totalpurchaseduemoneys = collect($purchasemoneys)->sum('due');
        $totalspendmoneys = collect($spendmoneys)->sum('spending_price');
        $investment_capital = collect($general_settings)->sum('investment_capital');
        $totalboxmoneys = $investment_capital + $totalsalemoneys + $totalpurchaseduemoneys - $totalpurchasemoneys - $totalspendmoneys - $totalsaleduemoneys;

        return view('dashboard.box.index', compact(
            'salemoneys',
            'purchasemoneys',
            'spendmoneys',
            'totalsalemoneys',
            'totalpurchasemoneys',
            'totalsaleduemoneys',
            'totalpurchaseduemoneys',
            'totalspendmoneys',
            'totalboxmoneys'
        ));
    }
}
