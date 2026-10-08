<?php

namespace Database\Seeders;

use App\Models\PortfolioProject;
use Illuminate\Database\Seeder;

class PortfolioProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            ['name' => 'Think Code', 'slug' => 'think-code', 'description' => 'ThinkCode is a modern web-based platform for managing and organizing coding tutorials, lessons and learning resources through a clean, responsive and secure interface.', 'body' => 'ThinkCode is designed to provide an organized platform for coding education and development resources. Administrators can manage courses, tutorials, lessons and learning content while users explore the material through a simple, responsive experience. The project focuses on performance, SEO-friendly structure, secure authentication and a scalable Laravel architecture.', 'github_url' => 'https://github.com/alikhore12/Think-Code.git', 'image_url' => 'images/thinkcode/home.png', 'gallery' => ['images/thinkcode/home.png', 'images/thinkcode/clients.png', 'images/thinkcode/expertise.png']],
            ['name' => 'MCMS', 'slug' => 'mcms', 'description' => 'MCMS (Medical Clinic Management System) is a modern web-based clinic management platform designed to simplify daily medical clinic operations.', 'body' => 'MCMS provides a centralized dashboard where clinic administrators can manage patients, appointments, doctors, consultations, prescriptions, invoices and clinic activities. The system gives staff a clear overview of daily appointments, checked-in patients, ongoing consultations, total patients, revenue and open invoices. It also includes quick actions for adding patients, creating appointments, starting consultations and generating invoices. The interface is clean, responsive and user-friendly so clinic staff can manage day-to-day operations from one organized platform.', 'github_url' => 'https://github.com/alikhore12/MCMS.git', 'image_url' => 'images/mcms/dashboard.png'],
        ];

        foreach ($projects as $project) {
            PortfolioProject::updateOrCreate(
                ['slug' => $project['slug']],
                array_merge($project, [
                    'category' => 'Web Application',
                    'body' => $project['body'] ?? $project['description'],
                    'gallery' => $project['gallery'] ?? [],
                    'tags' => $project['slug'] === 'think-code' ? ['PHP', 'Laravel', 'MySQL', 'HTML', 'CSS', 'JavaScript'] : ($project['slug'] === 'mcms' ? ['PHP', 'Laravel', 'MySQL', 'HTML', 'CSS', 'JavaScript'] : []),
                    'features' => $project['slug'] === 'think-code' ? ['Tutorial and lesson management', 'Admin dashboard content management', 'Responsive learning interface', 'Secure authentication and SEO-ready structure'] : ($project['slug'] === 'mcms' ? ['Patient management', 'Appointment scheduling', 'Doctor and consultation management', 'Prescriptions and invoices', 'Operational dashboard and clinic activity overview'] : []),
                    'accent' => 'coral',
                    'year' => '2026',
                    'published' => true,
                ])
            );
        }
    }
}
