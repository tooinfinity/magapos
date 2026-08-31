<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(Request $request): View
    {
        $providers = Provider::all();
        $categories = Category::all();
        $products = Product::all();
        $purchases = Purchase::all();
        return view('dashboard.purchase.index', compact('purchases', 'providers', 'categories', 'products'));
    }

    public function create(): View
    {
        $providers = Provider::all();
        $categories = Category::all();
        $products = Product::all();

        if (Purchase::all()->last() === null) {
            $purchase_number = 'PN : 1 / ' . date('Y');
        } else {
            $lastpurchaseNumber = Purchase::all()->last()->number_purchase;
            $lastNumber = substr($lastpurchaseNumber, 5, -7);
            $purchase_number = 'PN : ' . str_pad($lastNumber + 1, 0, 0, STR_PAD_LEFT) . ' / ' . date('Y');
        }

        if (Product::all()->last() === null) {
            $barcode_number = '000000000001';
        } else {
            $lastproductId = Product::all()->last()->id;
            $lastIncreament = substr($lastproductId, -12);
            $barcode_number = str_pad($lastIncreament + 1, 12, '0', STR_PAD_LEFT);
        }

        return view('dashboard.purchase.create', compact('purchase_number', 'barcode_number', 'providers', 'categories', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'number_purchase' => 'required',
            'total' => 'required',
            'discount' => 'required',
            'total_amount' => 'required',
            'paid' => 'required',
            'credit' => 'required',
            'status' => 'required',
            'provider_id' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);

        $data = $request->all();

        $purchase = Purchase::create([
            'number_purchase' => $data['number_purchase'],
            'total' => $data['total'],
            'discount' => $data['discount'],
            'total_amount' => $data['total_amount'],
            'paid' => $data['paid'],
            'due' => $data['credit'],
            'status' => $data['status'],
            'provider_id' => $data['provider_id'],
        ]);

        $dat = $data['product'];
        $qty = $request->get('quantity');
        $attach_data = [];
        for ($i = 0; $i < count($dat); $i++) {
            $attach_data[$dat[$i]] = ['quantity' => $qty[$i]];
        }
        $purchase->products()->attach($attach_data);

        for ($i = 0; $i < count($dat); $i++) {
            $product = Product::find($dat[$i]);
            $product->stock = $product->stock + $qty[$i];
            $product->save();
        }

        return redirect()->back();
    }

    public function show(Purchase $purchase): View
    {
        $product_purchases = $purchase->products;
        $provider_purchases = $purchase->provider;
        $i = 0;

        return view('dashboard.purchase.showtwo', compact('product_purchases', 'provider_purchases', 'purchase', 'i'));
    }

    public function edit(Purchase $purchase): View
    {
        $providersel = $purchase->provider;
        $providers = Provider::all();
        $categories = Category::all();
        $products = Product::all();
        return view('dashboard.purchase.edit', compact('purchase', 'providersel', 'providers', 'categories', 'products'));
    }

    public function update(Request $request, Purchase $purchase): RedirectResponse
    {
        $request->validate([
            'number_purchase' => 'required',
            'total' => 'required',
            'discount' => 'required',
            'total_amount' => 'required',
            'paid' => 'required',
            'credit' => 'required',
            'status' => 'required',
            'provider_id' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);

        foreach ($purchase->products as $product) {
            $product->update([
                'stock' => $product->stock - $product->pivot->quantity,
            ]);
        }
        $purchase->delete();

        $data = $request->all();

        $purchase_update = Purchase::create([
            'number_purchase' => $data['number_purchase'],
            'total' => $data['total'],
            'discount' => $data['discount'],
            'total_amount' => $data['total_amount'],
            'paid' => $data['paid'],
            'due' => $data['credit'],
            'status' => $data['status'],
            'provider_id' => $data['provider_id'],
        ]);

        $dat = $data['product'];
        $qty = $request->get('quantity');
        $attach_data = [];
        for ($i = 0; $i < count($dat); $i++) {
            $attach_data[$dat[$i]] = ['quantity' => $qty[$i]];
        }
        $purchase_update->products()->attach($attach_data);

        for ($i = 0; $i < count($dat); $i++) {
            $product = Product::find($dat[$i]);
            $product->stock = $product->stock + $qty[$i];
            $product->save();
        }

        return redirect()->route('purchase.index');
    }

    public function paymentduep(Request $request, int $id): void
    {
        $credits = Purchase::findOrFail($id);
        $paid = $request->input('paid');
        $due = $request->input('credit');
        $pdue = $request->input('paidcredit');

        if ($pdue == $due) {
            $credits->due = $due - $pdue;
            $credits->paid = $paid + $pdue;
            $credits->status = 'paid';
        } elseif ($pdue < $due) {
            $credits->due = $due - $pdue;
            $credits->paid = $paid + $pdue;
            $credits->status = 'debt';
        }
        $credits->save();
    }

    public function destroy(Purchase $purchase): RedirectResponse
    {
        foreach ($purchase->products as $product) {
            $product->update([
                'stock' => $product->stock - $product->pivot->quantity,
            ]);
        }
        $purchase->delete();
        toast('Purchase deleted Successfully', 'error', 'top-right');
        return redirect()->back();
    }
}
