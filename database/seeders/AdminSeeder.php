<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
   public function run(): void
{
    User::updateOrCreate(
        ['email' => 'admin@ecloria.ma'], // إذا كان كاين، ما يزيدهش
        [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'phone' => '+212600000000',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]
    );
}
}
