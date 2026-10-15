<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = [];
            try {
                if (Schema::hasTable('settings')) {
                    $settings = Setting::all()->pluck('value', 'key')->toArray();
                }
            } catch (\Exception $e) {
                $settings = [];
            }

            $resolveUrl = function ($val, $fallback = null) {
                if (!$val) {
                    return $fallback;
                }
                if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://') || str_starts_with($val, '/')) {
                    return $val;
                }
                return asset('storage/' . $val);
            };

            // Default modern developer portrait fallback
            $defaultAvatar = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80';

            $heroImage = $resolveUrl($settings['hero_image'] ?? null, $defaultAvatar);
            $siteLogo  = $resolveUrl($settings['site_logo'] ?? null, $heroImage);
            $favicon   = $resolveUrl($settings['favicon'] ?? null, $siteLogo);

            $view->with('siteSettings', array_merge($settings, [
                'hero_image_url' => $heroImage,
                'site_logo_url'  => $siteLogo,
                'favicon_url'    => $favicon,
                'developer_name' => $settings['developer_name'] ?? 'Shahzad Ali',
                'developer_role' => $settings['developer_role'] ?? 'Senior Full-Stack Web Architect',
                'hero_tagline'   => $settings['hero_tagline'] ?? 'Engineering Scalable Web Applications & Digital Experiences',
            ]));
        });
    }
}
