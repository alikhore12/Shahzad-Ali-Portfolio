<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeds the database with an admin user, sample portfolio projects with images, and technical skills.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ───────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'info@shahzadlabs.com'],
            [
                'name'     => 'Shahzad Labs Admin',
                'password' => Hash::make('password'),
            ]
        );

        // ── Projects ────────────────────────────────────────────────
        // Projects are not pre-seeded; they are managed dynamically through the Admin Dashboard.

        // ── Technical Skills & Stack ─────────────────────────────────
        $skills = [
            // Backend
            ['name' => 'Laravel', 'category' => 'backend', 'proficiency' => 95, 'icon' => '🔴', 'experience' => '5+ Years', 'order' => 1, 'is_featured' => true],
            ['name' => 'PHP 8.3+', 'category' => 'backend', 'proficiency' => 92, 'icon' => '🐘', 'experience' => '5+ Years', 'order' => 2, 'is_featured' => true],
            ['name' => 'RESTful APIs', 'category' => 'backend', 'proficiency' => 94, 'icon' => '🔗', 'experience' => '4+ Years', 'order' => 3, 'is_featured' => true],
            ['name' => 'Queue Workers', 'category' => 'backend', 'proficiency' => 88, 'icon' => '⚡', 'experience' => '3+ Years', 'order' => 4, 'is_featured' => false],

            // Frontend
            ['name' => 'Tailwind CSS', 'category' => 'frontend', 'proficiency' => 95, 'icon' => '🎨', 'experience' => '4+ Years', 'order' => 5, 'is_featured' => true],
            ['name' => 'JavaScript (ES6+)', 'category' => 'frontend', 'proficiency' => 90, 'icon' => '⚡', 'experience' => '5+ Years', 'order' => 6, 'is_featured' => true],
            ['name' => 'Alpine.js / Vue', 'category' => 'frontend', 'proficiency' => 88, 'icon' => '⚛️', 'experience' => '3+ Years', 'order' => 7, 'is_featured' => true],
            ['name' => 'HTML5 & CSS3', 'category' => 'frontend', 'proficiency' => 98, 'icon' => '📄', 'experience' => '6+ Years', 'order' => 8, 'is_featured' => false],

            // Database
            ['name' => 'MySQL', 'category' => 'database', 'proficiency' => 92, 'icon' => '🐬', 'experience' => '5+ Years', 'order' => 9, 'is_featured' => true],
            ['name' => 'Redis Caching', 'category' => 'database', 'proficiency' => 85, 'icon' => '⚡', 'experience' => '3+ Years', 'order' => 10, 'is_featured' => true],
            ['name' => 'Eloquent ORM', 'category' => 'database', 'proficiency' => 96, 'icon' => '🗄️', 'experience' => '5+ Years', 'order' => 11, 'is_featured' => false],

            // DevOps & Cloud
            ['name' => 'Git & GitHub', 'category' => 'devops', 'proficiency' => 92, 'icon' => '🔀', 'experience' => '5+ Years', 'order' => 12, 'is_featured' => true],
            ['name' => 'Docker & Containers', 'category' => 'devops', 'proficiency' => 82, 'icon' => '🐳', 'experience' => '2+ Years', 'order' => 13, 'is_featured' => true],
            ['name' => 'CI/CD Pipelines', 'category' => 'devops', 'proficiency' => 84, 'icon' => '🔄', 'experience' => '3+ Years', 'order' => 14, 'is_featured' => false],

            // Tools & Architecture
            ['name' => 'MVC & Clean Code', 'category' => 'tools', 'proficiency' => 95, 'icon' => '🏛️', 'experience' => '5+ Years', 'order' => 15, 'is_featured' => true],
            ['name' => 'Postman & Swagger', 'category' => 'tools', 'proficiency' => 90, 'icon' => '📜', 'experience' => '4+ Years', 'order' => 16, 'is_featured' => false],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill['name']], $skill);
        }

        // ── Site Branding Settings ──────────────────────────────────
        $defaultBrandImg = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80';
        \App\Models\Setting::updateOrCreate(['key' => 'hero_image'], ['value' => $defaultBrandImg]);
        \App\Models\Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $defaultBrandImg]);
        \App\Models\Setting::updateOrCreate(['key' => 'favicon'], ['value' => $defaultBrandImg]);
        \App\Models\Setting::updateOrCreate(['key' => 'developer_name'], ['value' => 'Shahzad Ali']);
        \App\Models\Setting::updateOrCreate(['key' => 'developer_role'], ['value' => 'Senior Full-Stack Web Architect']);
        \App\Models\Setting::updateOrCreate(['key' => 'hero_tagline'], ['value' => 'Engineering Scalable Web Applications & Digital Experiences']);
    }
}
