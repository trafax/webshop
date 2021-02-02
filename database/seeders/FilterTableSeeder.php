<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Filter::create([
            'title' => 'Hoeveelheid',
            'slug' => 'hoeveelheid',
            'required' => 1,
            'multiple' => 0,
            'selectable' => 1,
            'sort' => 0,
        ]);

        \App\Models\Filter::create([
            'title' => 'Kleur',
            'slug' => 'kleur',
            'required' => 0,
            'multiple' => 0,
            'selectable' => 0,
            'sort' => 1,
        ]);
    }
}
