<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(['id' => 1], [
            'name' => 'Shahzad Ali',
            'title' => 'Full-Stack Web Developer',
            'image_path' => 'images/shahzad-ali.png',
        ]);
    }
}
