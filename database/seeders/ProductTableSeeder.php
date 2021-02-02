<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Product::create([
            'sort' => 0,
            'title' => 'Voorbeeld product',
            'slug' => 'voorbeeld-product',
            'sku' => 'P10001',
            'price' => '10.95',
        ]);
    }
}
