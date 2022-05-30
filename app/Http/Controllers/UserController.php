<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::orderBy('id', 'asc')->paginate(5);
        $sellers = User::where('role', 'seller')
            ->orderBy('id', 'asc')
            ->paginate(5);

        if ($user->hasRole('admin')) {
            return Inertia::render('User/Admin/Index', compact('users'));
        }
        else if ($user->hasRole('manager')) {
            return Inertia::render('User/Manager/Index', compact('sellers'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();

        if ($auth->hasRole('admin')) {
            return Inertia::render('User/Admin/Create');
        }
        else if ($auth->hasRole('manager')) {
            return Inertia::render('User/Manager/Create');
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
        $auth = Auth::user();
        if ($auth->hasRole('admin')) {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => $request->get('role')
            ]);

            $auth_info = [
                "id" => $auth->id,
                "name" => $auth->name
            ];

            event(new UserRegistered($user, $auth_info));

            return response()->json([
                'id' => $user->id
            ]);
        }
        else if ($auth->hasRole('manager')) {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => 'seller',
                'manager_id' => $auth->id,
            ]);

            $auth_info = [
                "id" => $auth->id,
                "name" => $auth->name
            ];

            event(new UserRegistered($user, $auth_info));

            return response()->json([
                'id' => $user->id
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
        $auth = Auth::user();
        $user = User::where('id', $id)->first();

        if ($auth->hasRole('admin')) {
            return Inertia::render('User/Admin/Show', compact('user'));
        }
        else if ($auth->hasRole('manager')) {
            return Inertia::render('User/Admin/Show', compact('user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auth = Auth::user();
        $user = User::where('id', $id)->first();

        if ($auth->role == 'admin') {
            return Inertia::render('User/Admin/Edit', compact('user'));
        }
        else if ($auth->role == 'manager') {
            return Inertia::render('User/Manager/Edit', compact('user'));
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
        $auth = Auth::user();
        if ($auth->hasRole('admin')) {
            $user = User::where('id', $id)->first();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->role = $request->get('role');

            $user->save();
        }
        else if ($auth->hasRole('manager')){
            $user = User::where('id', $id)->first();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->role = 'seller';

            $user->save();
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
        $user = User::where('id', $id)->first();
        $user->delete();
    }
}
