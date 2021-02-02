<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::create([
            'parent_id' => 0,
            'sort' => 0,
            'title' => 'Voorbeeld categorie',
            'slug' => 'voorbeeld-categorie',
        ]);
    }
}
