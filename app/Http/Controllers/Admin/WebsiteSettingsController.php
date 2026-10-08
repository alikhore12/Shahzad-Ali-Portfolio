<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => [
                'site_name' => Setting::value('site_name', 'Shahzad Ali'),
                'site_tagline' => Setting::value('site_tagline', 'A full-stack developer in progress, making the web a little more human.'),
                'contact_email' => Setting::value('contact_email', config('mail.from.address')),
                'footer_tagline' => Setting::value('footer_tagline', 'Designed with warmth — Built with Laravel'),
                'availability_note' => Setting::value('availability_note', 'Available for selected freelance and collaborative projects.'),
            ],
            'socialLinks' => \App\Models\SocialLink::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:80'],
            'site_tagline' => ['required', 'string', 'max:220'],
            'contact_email' => ['required', 'email', 'max:150'],
            'footer_tagline' => ['required', 'string', 'max:180'],
            'availability_note' => ['required', 'string', 'max:220'],
        ]);

        Setting::many($data);

        return redirect()->route('admin.settings.edit')->with('success', 'Website settings saved.');
    }
}
