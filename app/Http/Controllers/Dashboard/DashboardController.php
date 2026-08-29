<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Spending;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): Renderable
    {
        $moderator = User::all();
        $categories = Category::all();
        $products = Product::all();
        $sales = Sale::all();
        $purchases = Purchase::all();
        $spendmoneys = Spending::all();
        $totalspendmoneys = collect($spendmoneys)->sum('spending_price');

        $today = Carbon::today();
        $sales_today = Sale::whereDate('created_at', '=', $today);
        $sale_due_today = Sale::whereDate('created_at', '=', $today)->sum('due');
        $spending_today = Spending::whereDate('created_at', '=', $today)->sum('spending_price');
        $purchases_today = Purchase::whereDate('created_at', '=', $today);

        $topsales = DB::table('product_sale')
            ->leftJoin('products', 'products.id', '=', 'product_sale.product_id')
            ->select(
                'products.id',
                'products.product_name',
                'product_sale.product_id',
                DB::raw('SUM(product_sale.quantity) as total')
            )
            ->groupBy('products.id', 'product_sale.product_id', 'products.product_name')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();

        $toppurchases = DB::table('product_purchase')
            ->leftJoin('products', 'products.id', '=', 'product_purchase.product_id')
            ->select(
                'products.id',
                'products.product_name',
                'product_purchase.product_id',
                DB::raw('SUM(product_purchase.quantity) as total')
            )
            ->groupBy('products.id', 'product_purchase.product_id', 'products.product_name')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();

        $sale_profit = DB::table('product_sale')
            ->leftJoin('products', 'products.id', '=', 'product_sale.product_id')
            ->leftJoin('sales', 'sales.id', '=', 'product_sale.sale_id')
            ->select(
                'sales.id',
                'products.product_name',
                'products.sale_price',
                'products.purchase_price',
                'product_sale.product_id',
                'product_sale.quantity as qty',
                'sales.created_at',
                DB::raw('SUM(products.sale_price - products.purchase_price) * product_sale.quantity as profits'),
                DB::raw('DATE(sales.created_at) as date')
            )
            ->groupBy('sales.id', 'product_sale.product_id', 'products.product_name', 'sales.created_at', 'date', 'qty')
            ->orderBy('date')
            ->whereDate('sales.created_at', '=', $today)
            ->get();

        $sumprofit = $sale_profit->sum('profits') - $sale_due_today - $spending_today;

        $stock_alerts = DB::table('products')->where('stock', '<=', 'min_stock')->paginate(3, ['*'], 'stockalert');

        return view('dashboard.index', compact(
            'moderator',
            'categories',
            'products',
            'sumprofit',
            'topsales',
            'toppurchases',
            'stock_alerts',
            'sales',
            'sales_today',
            'purchases',
            'purchases_today',
            'totalspendmoneys'
        ));
    }

    public function pos(): Renderable
    {
        $moderator = User::all();
        $categories = Category::all();
        $products = Product::all();
        return view('dashboard.pos.index', compact('moderator', 'categories', 'products'));
    }
}
