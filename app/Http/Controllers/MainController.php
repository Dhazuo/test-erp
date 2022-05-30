<?php

namespace App\Http\Controllers;

use App\Events\SaleDeleteRequest;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('management.index');
        }

        return Inertia::render('Index');
    }

    public function confirmPassword(Request $request)
    {
        $password = $request->get('password');
        $user = User::where('id', Auth::id())->first();

        if (Hash::check($password, $user->password)) {
            return response()->json([
                'success' => 'Confirmed'
            ], 200);
        }

        return response()->json([
            'error' => 'Contraseña incorrecta'
        ], 401);
    }

    public function sendDeleteRequest(Request $request)
    {
        $id = $request->get('id');

        $find_sale = Sale::where('id', $id)->first();

        $find_sale->status = 'pending_to_delete';

        $find_sale->save();

        $auth = Auth::user();

        $auth_info = [
            "id" => $auth->id,
            "name" => $auth->name,
        ];

        DB::table('pending_to_delete')->insert([
            'petitioner_id' => $auth->id,
            'petitioner_name' => $auth->name,
            'sale_id' => $find_sale->id,
            'sale_token' => $find_sale->token
        ]);
        event(new SaleDeleteRequest($find_sale, $auth_info));

        return response()->json([
            "status" => $find_sale->status,
            "success" => "La petición de eliminación ha sido enviada. En cuanto sea eliminada o rechazada, recibirás una notificación de confirmación."
        ]);
    }
}
