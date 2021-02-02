<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'firstname' => 'S',
            'insertion' => 'van',
            'lastname' => 'Spelden',
            'email' => 'info@vanspelden.nl',
            'password' => '$2y$10$gNA12aOa/pmUKYVQyOssROeINBIPq/hOtqGJXVN37H/KnCdJqBGym',
            'role' => 'admin'
        ]);
    }
}
