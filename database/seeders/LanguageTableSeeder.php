<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Language::create([
            'title' => 'Nederlands',
            'iso' => 'nl',
            'default' => 1,
            'sort' => 0
        ]);

        \App\Models\Language::create([
            'title' => 'Engels',
            'iso' => 'en',
            'default' => NULL,
            'sort' => 1
        ]);
    }
}
