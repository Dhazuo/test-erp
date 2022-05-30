<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::orderBy('id', 'asc')->paginate(8);

        if ($user->hasRole('seller')) {
            return Inertia::render('Product/Seller/Index', compact('products'));
        }
        return Inertia::render('Product/Index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'original_stock' => $request->get('original_stock'),
            'actual_stock' => $request->get('original_stock')
        ]);

        ProductSale::create([
            'product_id' => $product->id,
            'total_sales' => 0,
            'total_gains' => 0,
        ]);

        return response()->json([
            'id' => $product->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $total_sales = $product->product_sale->total_sales;
        $total = $product->product_sale->total_gains;
        if ($total == 0) {
            $total = $total;
            $total_gains = 0;
        } else {
            $total_gains = ($total - ($total * 0.16));
            $total_gains = number_format((float) $total_gains, 2, '.', ',');
        }

        return Inertia::render('Product/Show',compact(['product','total_sales', 'total_gains']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return Inertia::render('Product/Edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $name = $request->get('name');
        $price = $request->get('price');
        $new_stock = $request->get('new_stock');

        $product->name = $name;
        $product->price = $price;
        $product->actual_stock = $new_stock;

        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->product_sale->delete();
        $product->delete();

    }
}
