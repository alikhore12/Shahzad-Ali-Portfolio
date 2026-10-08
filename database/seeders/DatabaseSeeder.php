<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PortfolioProjectSeeder::class);
        $this->call(PortfolioServiceSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(ProfileSeeder::class);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@shahzadlabs.com',
        ]);
    }
}
