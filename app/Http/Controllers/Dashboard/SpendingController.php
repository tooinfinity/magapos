<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Spending;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SpendingController extends Controller
{
    public function index(): View
    {
        $spendings = Spending::all();
        $totalspendings = collect($spendings)->sum('spending_price');
        return view('dashboard.spending.index', compact('spendings', 'totalspendings'));
    }

    public function create(): void
    {
        //
    }

    public function store(Request $request): void
    {
        $request->validate([
            'spending_name' => 'required',
            'spending_description' => 'required',
            'spending_price' => 'required',
        ]);

        Spending::create($request->all());
    }

    public function show(Spending $spending): void
    {
        //
    }

    public function edit(Spending $spending): void
    {
        //
    }

    public function updatespend(Request $request, int $id): void
    {
        $request->validate([
            'spending_name' => 'required',
            'spending_description' => 'required',
            'spending_price' => 'required',
        ]);

        $spending = Spending::findOrFail($id);
        $spending->spending_name = $request->input('spending_name');
        $spending->spending_description = $request->input('spending_description');
        $spending->spending_price = $request->input('spending_price');
        $spending->save();
    }

    public function destroy(Spending $spending): RedirectResponse
    {
        $spending->delete();
        return redirect()->back();
    }
}
