<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        $products = Product::when($request->search, function ($q) use ($request) {
            return $q->where('product_name', 'like', '%' . $request->search . '%');
        })->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(5);

        return view('dashboard.product.index', compact('categories', 'products'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('dashboard.product.create', compact('categories'));
    }

    public function barcode(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            if (Product::all()->last() === null) {
                $barcode_number = '000000000001';
            } else {
                $lastproductId = Product::all()->last()->id;
                $lastIncreament = substr($lastproductId, -12);
                $barcode_number = str_pad($lastIncreament + 1, 12, '0', STR_PAD_LEFT);
            }
            return response()->json([
                'barcode_number' => $barcode_number,
            ]);
        }
    }

    public function store(Request $request): ?RedirectResponse
    {
        $request->validate([
            'category_id' => 'required',
            'codebar' => 'required|unique:products,codebar',
            'product_name' => 'required|unique:products,product_name',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
            'min_stock' => 'required',
        ]);

        $request_data = $request->all();
        if ($request->image) {
            $manager = new ImageManager(new GdDriver());
            $manager->make($request->image->getRealPath())
                ->resize(160, 160, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        Product::create($request_data);
        toast('Created Successfully', 'success', 'top-right');
        if (! $request->ajax()) {
            return redirect()->route('product.index');
        }
        return null;
    }

    public function show(Product $product): void
    {
        //
    }

    public function searchsale(Request $request): JsonResponse
    {
        $products = Product::when($request->searchbyproduct, function ($q) use ($request) {
            return $q->where('product_name', 'like', '%' . $request->searchbyproduct . '%');
        })->when($request->searchbycategoty, function ($q) use ($request) {
            return $q->where('category_id', $request->searchbycategoty);
        })->get();

        return response()->json(['products' => $products]);
    }

    public function searchpurchase(Request $request): JsonResponse
    {
        $output = '';
        $product = $request->pro;
        $products = Product::where('product_name', 'like', '%' . $product . '%')->get();
        foreach ($products as $product) {
            $output .= '<div class="col-md-2 col-md-offset-1" style="margin:0;">
                <div id="update_product_price_button" data-tooltip="tooltip" title="Update product" data-toggle="modal" data-target="#modal-update-price"
                            data-name="' . $product->product_name . '" + data-id="' . $product->id . '" +
                            data-price="' . $product->purchase_price . '" + data-sale="' . $product->sale_price . '"
                            class="btn btn-primary btn-sm" style="position: absolute; top: 0; right: 15px;z-index: 1;">
                            <i class="fas fa-edit"></i>
                        </div>
                <a href="" id="product" data-tooltip="tooltip" title="Price : ' . $product->purchase_price . ' stock : ' . $product->stock . '"
                            data-placement="top" id="product-' . $product->id . '" +
                            data-name="' . $product->product_name . '" + data-id="' . $product->id . '" +
                            data-price="' . $product->purchase_price . '" + data-stock="' . $product->stock . '" + data-sale="' . $product->sale_price . '" class="con d-block mb-4
                                add-product-btn">
                            <img class="img-fluid img-product" src="' . $product->image_path . '" alt="">
                            <span class="mbr-gallery-title text-truncate">' . $product->product_name . '</span>
                        </a>
                    </div>';
        }

        return response()->json(['row_result' => $output]);
    }

    public function addproduct(Request $request): JsonResponse
    {
        $barcode = $request->code;
        $products = Product::where('codebar', '=', $barcode)->get();
        return response()->json(['product' => $products]);
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('dashboard.product.edit', compact('categories', 'product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required',
            'codebar' => [
                'digits:13',
                'required',
                Rule::unique('products')->ignore($product->id),
            ],
            'product_name' => [
                'required',
                Rule::unique('products')->ignore($product->id),
            ],
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
            'min_stock' => 'required',
            'image' => 'image',
        ]);

        $request_data = $request->all();
        if ($request->image) {
            if ($product->image != 'product.png') {
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            }
            $manager = new ImageManager(new GdDriver());
            $manager->make($request->image->getRealPath())
                ->resize(160, 160, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        $product->update($request_data);
        toast('Product Updated Successfully', 'success', 'top-right');
        return redirect()->back();
    }

    public function updateprice(Request $request, int $id): void
    {
        $request->validate([
            'purchase_price' => 'required',
            'sale_price' => 'required',
        ]);
        $productprice = Product::findOrFail($id);
        $productprice->purchase_price = $request->input('purchase_price');
        $productprice->sale_price = $request->input('sale_price');
        $productprice->save();
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image != 'product.png') {
            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
        }
        $product->delete();
        toast('Product deleted Successfully', 'error', 'top-right');
        return redirect()->route('product.index');
    }
}
