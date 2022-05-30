<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $find = User::where('email', $email)->first();

        if ($find) {
            $password_comprobation = Hash::check($password, $find->password);

            if ($password_comprobation) {
                return response()->json([
                    "a" => $find
                ]);
                Auth::login($find);
                $request->session()->regenerate();
                return redirect()->intended(route('management.index'));
            }
            return response()->json([
                'error' => "Si no puedes acceder, contacta con tu administrador."
            ], 401);

        }

        return response()->json([
            'error' => 'Si no puedes acceder, contacta con tu administrador.'
        ], 401);

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('index');
    }

}
