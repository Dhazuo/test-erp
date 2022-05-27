<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $seller = User::where('role', 'seller')->first();

        dd($seller->sales);
    }
}
