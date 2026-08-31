<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(): View
    {
        $clients = Client::all();
        $categories = Category::all();
        $products = Product::all();
        $sales = Sale::all();
        return view('dashboard.sale.index', compact('sales', 'clients', 'categories', 'products'));
    }

    public function create(): View
    {
        $clients = Client::all();
        $categories = Category::all();
        $products = Product::all();

        if (Sale::all()->last() === null) {
            $sale_number = 'SN : 1 / ' . date('Y');
        } else {
            $lastsaleNumber = Sale::all()->last()->number_sale;
            $lastNumber = substr($lastsaleNumber, 5, -7);
            $sale_number = 'SN : ' . str_pad($lastNumber + 1, 0, 0, STR_PAD_LEFT) . ' / ' . date('Y');
        }

        return view('dashboard.sale.create', compact('sale_number', 'clients', 'categories', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'number_sale' => 'required',
            'total' => 'required',
            'discount' => 'required',
            'total_amount' => 'required',
            'paid' => 'required',
            'credit' => 'required',
            'status' => 'required',
            'client_id' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);

        $data = $request->all();

        $sale = Sale::create([
            'number_sale' => $data['number_sale'],
            'total' => $data['total'],
            'discount' => $data['discount'],
            'total_amount' => $data['total_amount'],
            'paid' => $data['paid'],
            'due' => $data['credit'],
            'status' => $data['status'],
            'client_id' => $data['client_id'],
        ]);

        $dat = $data['product'];
        $qty = $request->get('quantity');
        $attach_data = [];
        for ($i = 0; $i < count($dat); $i++) {
            $attach_data[$dat[$i]] = ['quantity' => $qty[$i]];
        }
        $sale->products()->attach($attach_data);

        for ($i = 0; $i < count($dat); $i++) {
            $product = Product::find($dat[$i]);
            if ($product->stock == 0) {
                toast('this product stock is empty', 'error', 'top-right');
            } else {
                $product->stock = $product->stock - $qty[$i];
                $product->save();
            }
        }

        return redirect()->back();
    }

    public function show(Sale $sale): View
    {
        $product_sales = $sale->products;
        $client_sales = $sale->client;
        $i = 0;

        return view('dashboard.sale.showtwo', compact('product_sales', 'client_sales', 'sale', 'i'));
    }

    public function edit(Sale $sale): View
    {
        $clientsel = $sale->client;
        $clients = Client::all();
        $categories = Category::all();
        $products = Product::all();
        return view('dashboard.sale.edit', compact('sale', 'clientsel', 'clients', 'categories', 'products'));
    }

    public function update(Request $request, Sale $sale): RedirectResponse
    {
        $request->validate([
            'number_sale' => 'required',
            'total' => 'required',
            'discount' => 'required',
            'total_amount' => 'required',
            'paid' => 'required',
            'credit' => 'required',
            'status' => 'required',
            'client_id' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);

        foreach ($sale->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }
        $sale->delete();

        $data = $request->all();

        $sale_update = Sale::create([
            'number_sale' => $data['number_sale'],
            'total' => $data['total'],
            'discount' => $data['discount'],
            'total_amount' => $data['total_amount'],
            'paid' => $data['paid'],
            'due' => $data['credit'],
            'status' => $data['status'],
            'client_id' => $data['client_id'],
        ]);

        $dat = $data['product'];
        $qty = $request->get('quantity');
        $attach_data = [];
        for ($i = 0; $i < count($dat); $i++) {
            $attach_data[$dat[$i]] = ['quantity' => $qty[$i]];
        }
        $sale_update->products()->attach($attach_data);

        for ($i = 0; $i < count($dat); $i++) {
            $product = Product::find($dat[$i]);
            if ($product->stock == 0) {
                toast('this product stock is empty', 'error', 'top-right');
            } else {
                $product->stock = $product->stock - $qty[$i];
                $product->save();
            }
        }

        return redirect()->route('sale.index');
    }

    public function paymentdue(Request $request, int $id): void
    {
        $credits = Sale::findOrFail($id);
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

    public function destroy(Sale $sale): RedirectResponse
    {
        foreach ($sale->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }
        $sale->delete();
        toast('Sale deleted Successfully', 'error', 'top-right');
        return redirect()->back();
    }
}
