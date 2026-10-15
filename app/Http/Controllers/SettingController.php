<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show site branding and settings form.
     */
    public function edit()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update site branding, hero image, logo, and favicon.
     */
    public function update(Request $request)
    {
        $request->validate([
            'hero_image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'hero_image_url'  => ['nullable', 'url', 'max:1000'],
            'site_logo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'site_logo_url'   => ['nullable', 'url', 'max:1000'],
            'favicon'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg,ico', 'max:2048'],
            'favicon_url'     => ['nullable', 'url', 'max:1000'],
            'developer_name'  => ['nullable', 'string', 'max:100'],
            'developer_role'  => ['nullable', 'string', 'max:150'],
            'hero_tagline'    => ['nullable', 'string', 'max:255'],
        ]);

        // 1. Process Hero Image
        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('branding', 'public');
            Setting::set('hero_image', $path);
        } elseif ($request->filled('hero_image_url')) {
            Setting::set('hero_image', $request->input('hero_image_url'));
        }

        // 2. Process Site Logo
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('branding', 'public');
            Setting::set('site_logo', $path);
        } elseif ($request->filled('site_logo_url')) {
            Setting::set('site_logo', $request->input('site_logo_url'));
        }

        // 3. Process Favicon
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('branding', 'public');
            Setting::set('favicon', $path);
        } elseif ($request->filled('favicon_url')) {
            Setting::set('favicon', $request->input('favicon_url'));
        }

        // 4. Sync Hero Image to Logo & Favicon if requested
        if ($request->boolean('sync_hero_to_all')) {
            $currentHero = Setting::get('hero_image');
            if ($currentHero) {
                Setting::set('site_logo', $currentHero);
                Setting::set('favicon', $currentHero);
            }
        }

        // 5. Text Settings
        if ($request->has('developer_name')) {
            Setting::set('developer_name', $request->input('developer_name'));
        }
        if ($request->has('developer_role')) {
            Setting::set('developer_role', $request->input('developer_role'));
        }
        if ($request->has('hero_tagline')) {
            Setting::set('hero_tagline', $request->input('hero_tagline'));
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Site branding, Hero image, Navbar logo, and Favicon updated successfully!');
    }
}
