<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Country::create([
            'title' => 'Nederland',
            'iso' => 'nl',
            'eu' => 1,
            'sort' => 0
        ]);
    }
}
