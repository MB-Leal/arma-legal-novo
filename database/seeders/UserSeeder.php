<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'marcosbleal26@gmail.com'],
            ['name' => 'MARCOS BARROSO LEAL', 'password' => Hash::make('marcos123'), 'is_admin' => true]
        );

        User::updateOrCreate(
            ['email' => 'drikomaia89@gmail.com'],
            ['name' => 'ADRIANO MAIA', 'password' => Hash::make('adriano123'), 'is_admin' => true]
        );
    }
}
