<?php

namespace App\Http\Controllers;

use App\Events\SaleRegistered;
use App\Management\Token;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();


        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            $sales = Sale::orderBy('id', 'asc')->paginate(5) ? Sale::orderBy('id', 'asc')->paginate(5) : null;
            return Inertia::render('Sales/Index', compact('sales'));
        }
        else if ($user->hasRole('seller')) {
            $seller_sales = $user->sales() ? $user->sales()->orderBy('id', 'asc')->paginate(5) : null;
            return Inertia::render('Sales/Seller/Index', compact('seller_sales'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $products = Product::where('actual_stock', '!=', 0)->latest()->get(['name', 'price']);
        $customers = Customer::latest()->get('name');

        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            $sellers = User::where('role', 'seller')->latest()->get('name');
            return Inertia::render('Sales/Create', compact(['products', 'customers', 'sellers']));
        }
        else if ($user->hasRole('seller')) {
            return Inertia::render('Sales/Seller/Create', compact(['products', 'customers']));

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $t = new Token();
        $token = $t->generateToken();

        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            $total_stock = 0;
            $total_price = (float) 0;

            $products = $request->get('products');
            $seller_name = $request->get('seller');
            $customer_name = $request->get('customer');

            $find_seller = User::where('name', $seller_name)->first();
            $find_customer = Customer::where('name', $customer_name)->first();


            foreach ($products as $product) {
                $find_product = Product::where('name', $product["name"])->first();
                $price = $find_product->price * (int) $product["stock"];
                $total_price += $price;
                $total_stock += $product["stock"];
            }


            $sale = Sale::create([
                'token' => $token,
                'seller_id' => $find_seller->id,
                'seller_name' => $find_seller->name,
                'customer' => $find_customer->name,
                'total_stock' => $total_stock,
                'total_price' => $total_price
            ]);

            foreach ($products as $product) {
                $find = Product::where('name', $product["name"])->first();
                $find->sales()->attach($sale->id, ['total_stock' => $product["stock"]]);
            }

            $auth_info = [
                "id" => $user->id,
                "name" => $user->name,
            ];
            event(new SaleRegistered($sale, $auth_info));

            return response()->json([
                'total' => $total_price,
                'id' => $sale->id
            ]);
        }
        else if ($user->hasRole('seller')) {
            $total_stock = 0;
            $total_price = (float) 0;

            $products = $request->get('products');
            $customer_name = $request->get('customer');

            $find_customer = Customer::where('name', $customer_name)->first();


            foreach ($products as $product) {
                $find_product = Product::where('name', $product["name"])->first();
                $price = $find_product->price * (int) $product["stock"];
                $total_price += $price;
                $total_stock += $product["stock"];
            }


            $sale = Sale::create([
                'token' => $token,
                'seller_id' => $user->id,
                'seller_name' => $user->name,
                'customer' => $find_customer->name,
                'total_stock' => $total_stock,
                'total_price' => $total_price
            ]);

            foreach ($products as $product) {
                $find = Product::where('name', $product["name"])->first();
                $find->sales()->attach($sale->id, ['total_stock' => $product["stock"]]);
            }

            $auth_info = [
                "id" => $user->id,
                "name" => $user->name,
            ];

            if ($sale->total_price >= 10000) {
                event(new SaleRegistered($sale, $auth_info));
            }

            return response()->json([
                'total' => $total_price,
                'id' => $sale->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::where('id', $id)->first();
        $products_related = $sale->products;
        return Inertia::render('Sales/Show', compact(['sale', 'products_related']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        $sale = Sale::where('id', $id)->first();

        if ($user->hasRole('seller') && $sale->status == 'pending_to_delete'){
            return redirect()->route('management.sales.index');
        }

        $sale->products;
        $products = Product::where('actual_stock', '!=', 0)->latest()->get(['name', 'price']);
        $customers = Customer::latest()->get('name');

        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            $sellers = User::where('role', 'seller')->latest()->get('name');
            return Inertia::render('Sales/Edit', compact(['sale','products', 'customers', 'sellers']));
        }
        else if ($user->hasRole('seller')) {
            return Inertia::render('Sales/Seller/Edit', compact(['sale','products', 'customers']));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            $total_stock = 0;
            $total_price = (float) 0;

            $products = $request->get('products');
            $seller_name = $request->get('seller');
            $customer_name = $request->get('customer');

            $find_seller = User::where('name', $seller_name)->first();
            $find_customer = Customer::where('name', $customer_name)->first();

            $sale = Sale::where('id', $id)->first();
            $sale->products()->detach();

            foreach ($products as $product) {
                $find_product = Product::where('name', $product["name"])->first();
                $price = $find_product->price * (int) $product["stock"];
                $total_price += $price;
                $total_stock += $product["stock"];

                $find_product->sales()->attach($sale->id, ['total_stock' => $product["stock"]]);
            }

            $sale->seller_id = $find_seller->id;
            $sale->seller_name = $find_seller->name;
            $sale->customer = $find_customer->name;
            $sale->total_stock = $total_stock;
            $sale->total_price = $total_price;

            $sale->save();

            return response()->json([
                'total' => $total_price,
                'id' => $sale->id
            ]);
        }
        else if ($user->hasRole('seller')) {
            $total_stock = 0;
            $total_price = (float) 0;

            $products = $request->get('products');
            $customer_name = $request->get('customer');

            $find_customer = Customer::where('name', $customer_name)->first();

            $sale = Sale::where('id', $id)->first();
            $sale->products()->detach();

            foreach ($products as $product) {
                $find_product = Product::where('name', $product["name"])->first();
                $price = $find_product->price * (int) $product["stock"];
                $total_price += $price;
                $total_stock += $product["stock"];

                $find_product->sales()->attach($sale->id, ['total_stock' => $product["stock"]]);
            }

            $sale->seller_id = $user->id;
            $sale->seller_name = $user->name;
            $sale->customer = $find_customer->name;
            $sale->total_stock = $total_stock;
            $sale->total_price = $total_price;

            $sale->save();

            return response()->json([
                'total' => $total_price,
                'id' => $sale->id
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::where('id', $id)->first();
        $sale->delete();
    }


}
