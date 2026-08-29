<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProviderController extends Controller
{
    public function index(Request $request): View
    {
        $providers = Provider::all();
        return view('dashboard.provider.index', compact('providers'));
    }

    public function purchasedetail(int $id): View
    {
        $provider = Provider::findOrFail($id);
        return view('dashboard.provider.purchasedetail', compact('provider'));
    }

    public function create(): View
    {
        return view('dashboard.provider.create');
    }

    public function store(Request $request): ?RedirectResponse
    {
        $request->validate([
            'provider_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Provider::create($request->all());
        toast('Provider created Successfully', 'success', 'top-right');
        if (! $request->ajax()) {
            return redirect()->route('provider.index');
        }
        return null;
    }

    public function show(Provider $provider): void
    {
        //
    }

    public function edit(Provider $provider): View
    {
        return view('dashboard.provider.edit', compact('provider'));
    }

    public function update(Request $request, Provider $provider): RedirectResponse
    {
        $request->validate([
            'provider_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $provider->update($request->all());
        toast('Provider Updated Successfully', 'success', 'top-right');
        return redirect()->route('provider.index');
    }

    public function destroy(Provider $provider): RedirectResponse
    {
        $provider->delete();
        toast('Provider deleted Successfully', 'error', 'top-right');
        return redirect()->route('provider.index');
    }
}
