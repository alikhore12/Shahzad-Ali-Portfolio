<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'alikhore12@gmail.com')],
            [
                'name' => 'Shahzad Ali',
                'password' => env('ADMIN_PASSWORD', 'Shahzad@Portfolio2026!'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );
    }
}
