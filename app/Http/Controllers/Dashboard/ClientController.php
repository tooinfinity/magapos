<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $clients = Client::all();
        return view('dashboard.client.index', compact('clients'));
    }

    public function saledetail(int $id): View
    {
        $client = Client::findOrFail($id);
        return view('dashboard.client.saledetail', compact('client'));
    }

    public function create(): View
    {
        return view('dashboard.client.create');
    }

    public function store(Request $request): ?RedirectResponse
    {
        $request->validate([
            'client_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Client::create($request->all());
        toast('Client created Successfully', 'success', 'top-right');
        if (! $request->ajax()) {
            return redirect()->route('client.index');
        }
        return null;
    }

    public function show(Client $client): void
    {
        //
    }

    public function edit(Client $client): View
    {
        return view('dashboard.client.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $request->validate([
            'client_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $client->update($request->all());
        toast('Client Updated Successfully', 'success', 'top-right');
        return redirect()->route('client.index');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();
        toast('Client deleted Successfully', 'error', 'top-right');
        return redirect()->route('client.index');
    }
}
