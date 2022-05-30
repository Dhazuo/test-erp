<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
