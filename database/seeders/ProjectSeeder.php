<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Laravel Enterprise CRM',
                'slug' => 'laravel-enterprise-crm',
                'category' => 'case_study',
                'excerpt' => 'A comprehensive customer relationship management system built for a B2B enterprise, featuring lead tracking, pipeline management, and automated workflows.',
                'description' => 'Built a scalable Laravel-based CRM platform that replaced legacy spreadsheet tracking. The system includes role-based access control, automated follow-up sequences, and integrated communication tools. Key features: opportunity scoring, task automation, and real-time analytics dashboard.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1559146209-31d6ee588866?w=800&h=600&fit=crop',
                'banner_image_url' => 'https://images.unsplash.com/photo-1552664734-60179 blackstripes?w=1600&h=400&fit=crop',
                'live_url' => 'https://crm-demo.shahzadlabs.com',
                'client_name' => 'TechFlow Solutions',
                'timeline' => '180 days',
                'completed_at' => 'November 2024',
                'tech_stack' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Vue.js', 'Redis'],
                'is_featured' => true,
            ],
            [
                'title' => 'WordPress E-commerce Portal',
                'slug' => 'wordpress-ecommerce-portal',
                'category' => 'client_work',
                'excerpt' => 'A feature-rich online store built on WordPress with custom plugins and payment gateway integrations.',
                'description' => 'Developed a bespoke WordPress e-commerce solution for a retail client, integrating WooCommerce with custom payment processors and inventory management. The project included responsive design, product filtering, and abandoned cart recovery sequences.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1585225512202-5a09016074b5?w=800&h=600&fit=crop',
                'banner_image_url' => 'https://images.unsplash.com/photo-1568770512716-76688fa123d0?w=1600&h=400&fit=crop',
                'live_url' => 'https://store.shahzadlabs.com',
                'client_name' => 'GreenLeaf Organics',
                'timeline' => '90 days',
                'completed_at' => 'August 2024',
                'tech_stack' => ['WordPress', 'WooCommerce', 'PHP', 'Stripe', 'JavaScript'],
                'is_featured' => false,
            ],
            [
                'title' => 'React Dashboard Analytics',
                'slug' => 'react-dashboard-analytics',
                'category' => 'enterprise',
                'excerpt' => 'An interactive analytics dashboard for monitoring business metrics in real-time with custom visualizations.',
                'description' => 'Created a React-based dashboard that integrates with Laravel backend APIs to provide real-time business intelligence. Features include drag-and-drop widgets, custom chart visualizations, and role-based metric permissions.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1555764135-c966488c49ba?w=800&h=600&fit=crop',
                'banner_image_url' => 'https://images.unsplash.com/photo-1585225512716-76688fa123d0?w=1600&h=400&fit=crop',
                'live_url' => null,
                'client_name' => 'DataCorp Industries',
                'timeline' => '120 days',
                'completed_at' => 'March 2025',
                'tech_stack' => ['React', 'Laravel', 'Chart.js', 'TypeScript', 'Node.js'],
                'is_featured' => false,
            ],
            [
                'title' => 'Laravel SaaS Platform',
                'slug' => 'laravel-saaS-platform',
                'category' => 'case_study',
                'excerpt' => 'A Software-as-a-Service platform with subscription billing, user roles, and multi-tenant architecture.',
                'description' => 'Built a complete SaaS solution using Laravel with Stripe subscription management, multi-tenant architecture using Laravel Subscriber, and role-based feature flags. The platform supports tiered pricing plans and automated billing cycles.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1606080912336-83901ef7336e?w=800&h=600&fit=crop',
                'banner_image_url' => 'https://images.unsplash.com/photo-1573535217076-5b91507d0071?w=1600&h=400&fit=crop',
                'live_url' => 'https://saas-demo.shahzadlabs.com',
                'client_name' => 'CloudScale',
                'timeline' => '200 days',
                'completed_at' => 'January 2025',
                'tech_stack' => ['Laravel', 'PHP', 'Stripe', 'Redis', 'Docker'],
                'is_featured' => true,
            ],
            [
                'title' => 'SEO Optimization Toolkit',
                'slug' => 'seo-optimization-toolkit',
                'category' => 'seo_tools',
                'excerpt' => 'A comprehensive SEO analysis and optimization tool for websites, featuring keyword research and on-page analysis.',
                'description' => 'Developed a full-stack SEO tool that crawls websites, analyzes on-page factors, and provides actionable optimization recommendations. Includes keyword tracking, competitive analysis, and reporting features.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1556909114 oftech?w=800&h=600&fit=crop',
                'banner_image_url' => 'https://images.unsplash.com/photo-1565164918543-3b16b8b6d796?w=1600&h=400&fit=crop',
                'live_url' => 'https://seo-tool.shahzadlabs.com',
                'client_name' => 'MarketingAgency Pro',
                'timeline' => '60 days',
                'completed_at' => 'February 2025',
                'tech_stack' => ['PHP', 'Laravel', 'JavaScript', 'Elasticsearch', 'Vue.js'],
                'is_featured' => false,
            ],
            [
                'title' => 'Portfolio Website Redesign',
                'slug' => 'portfolio-website-redesign',
                'category' => 'personal',
                'excerpt' => 'My own professional portfolio website showcasing projects, skills, and services with a modern dark-themed design.',
                'description' => 'Redesigned my personal portfolio with a focus on responsive design, performance optimization, and SEO best practices. Features include dark/light mode, project filtering, contact form with Laravel backend, and an admin panel for content management.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1460925895917-auT15xBqwn0c?w=800&h=600&fit=crop',
                'banner_image_url' => 'https://images.unsplash.com/photo-1558655146-9f40e2a9b4f0?w=1600&h=400&fit=crop',
                'live_url' => 'https://shahzad-portfolio.vercel.app',
                'client_name' => 'Self',
                'timeline' => '45 days',
                'completed_at' => 'October 2025',
                'tech_stack' => ['Laravel', 'Tailwind CSS', 'Alpine.js', 'MySQL', 'Vite'],
                'is_featured' => true,
            ],
            [
                'title' => 'API Gateway Microservices',
                'slug' => 'api-gateway-microservices',
                'category' => 'enterprise',
                'excerpt' => 'A robust API gateway and microservices architecture for connecting multiple internal systems.',
                'description' => 'Engineered a Laravel-based API gateway that routes requests to various microservices, handles authentication via JWT, and provides rate limiting and request transformation. Supports versioning and documentation generation.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1581091012184-7cdf01722cba?w=800&h=600&fit=crop',
                'banner_image_url' => 'https://images.unsplash.com/photo-1618843137314-8a2b4e7e1e00?w=1600&h=400&fit=crop',
                'live_url' => null,
                'client_name' => 'Enterprise Corp',
                'timeline' => '220 days',
                'completed_at' => 'December 2024',
                'tech_stack' => ['Laravel', 'PHP', 'Docker', 'Kubernetes', 'Redis', 'GraphQL'],
                'is_featured' => false,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}