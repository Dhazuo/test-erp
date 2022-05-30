<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            [
                'name' => 'Prueba Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin@admin.com'),
                'role' => 'admin'
            ],
            [
                'name' => 'Prueba Manager',
                'email' => 'manager@manager.com',
                'password' => Hash::make('manager@manager.com'),
                'role' => 'manager'
            ],
            [
                'name' => 'Prueba Vendedor',
                'email' => 'seller@seller.com',
                'password' => Hash::make('seller@seller.com'),
                'role' => 'seller'
            ]
        ];

        foreach ($list as $user) {
            DB::table('users')->insert([
               'name' => $user['name'],
               'email' => $user['email'],
               'password' => $user['password'],
               'role' => $user['role']
            ]);
        }

        Product::factory(50)->create();

        for ($i = 1; $i <= 50; $i++) {
            DB::table('product_sales')->insert([
                'product_id' => $i,
                'total_sales' => random_int(0, 5000),
                'total_gains' => 0
            ]);
        }

        $products_sales = ProductSale::all();

        foreach ($products_sales as $product) {
            $p = Product::where('id', $product->product_id)->first();
            $product->total_gains = $product->total_sales * $p->price;
            $product->save();
        }
    }
}
