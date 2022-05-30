<?php

namespace App\Http\Controllers;

use App\Events\SaleConserved;
use App\Events\SaleDeleted;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SalesPendingToDeleteController extends Controller
{
    public function index()
    {
        $sales = DB::table('pending_to_delete')->orderBy('id', 'desc')->get();
        return Inertia::render('Sales/PendingToDelete/Index', compact('sales'));
    }

    public function show($id)
    {
        $find = DB::table('pending_to_delete')->where('sale_token', $id)->first();

        if ($find) {
            $sale = Sale::where('token', $id)->first();
            $products_related = $sale->products;

            return Inertia::render('Sales/PendingToDelete/Show', compact(['sale', 'find', 'products_related']));
        }

        abort(404);
    }

    public function reject(Request $request)
    {
        $token = $request->get('sale_token');

        $find = Sale::where('token', $token)->first();

        $find->status = 'active';
        $find->save();

        $seller = $find->seller_id;

        DB::table('pending_to_delete')->where('sale_token', $token)->delete();

        event(new SaleConserved($find, $seller));
    }

    public function delete(Request $request)
    {
        $token = $request->get('sale_token');

        $petition = DB::table('pending_to_delete')->where('sale_token', $token)->delete();

        $sale_to_save = Sale::where('token', $token)->first();

        $seller = $sale_to_save->seller_id;
        $token = $sale_to_save->token;

        $sale_to_save->products()->detach();
        $sale_to_save->delete();

        event(new SaleDeleted($seller, $token));

    }
}
