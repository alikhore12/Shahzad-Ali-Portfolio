<?php

namespace Database\Seeders;

use App\Models\PortfolioService;
use Illuminate\Database\Seeder;

class PortfolioServiceSeeder extends Seeder
{
    public function run(): void
    {
        PortfolioService::updateOrCreate(
            ['slug' => 'full-stack-web-development'],
            [
                'name' => 'Full-stack web development',
                'intro' => 'Reliable Laravel applications, APIs and database-backed experiences.',
                'details' => 'I can help shape a web product from its first routes and data model through to a responsive, accessible interface.',
                'points' => [
                    'Laravel and PHP application structure',
                    'MySQL database-backed features',
                    'REST API integration',
                    'Responsive Blade interfaces',
                ],
                'documents' => [
                    ['title' => 'Professional CV', 'filename' => 'professional-cv.pdf', 'path' => 'documents/cv/professional-cv.pdf'],
                    ['title' => 'Professional CV - Version 1', 'filename' => 'professional-cv-1.pdf', 'path' => 'documents/cv/professional-cv-1.pdf'],
                    ['title' => 'Professional CV - Version 2', 'filename' => 'professional-cv-2.pdf', 'path' => 'documents/cv/professional-cv-2.pdf'],
                    ['title' => 'Professional CV - Version 3', 'filename' => 'professional-cv-3.pdf', 'path' => 'documents/cv/professional-cv-3.pdf'],
                ],
                'published' => true,
            ]
        );
    }
}
