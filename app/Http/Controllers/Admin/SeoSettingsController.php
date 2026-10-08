<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SeoSettingsController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        return view('admin.seo.edit', [
            'seo' => [
                'title_suffix' => Setting::value('seo_title_suffix', 'Shahzad Ali'),
                'description' => Setting::value('seo_description', 'Portfolio of Shahzad Ali — a Laravel, PHP and JavaScript developer building thoughtful, SEO-friendly web experiences.'),
                'og_image' => Setting::value('seo_og_image'),
                'verification' => Setting::value('seo_verification'),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title_suffix' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:300'],
            'og_image' => ['nullable', 'image', 'max:4096'],
            'og_image_url' => ['nullable', 'string', 'max:300'],
            'verification' => ['nullable', 'string', 'max:120'],
        ]);

        $ogImage = Setting::value('seo_og_image');
        if ($request->hasFile('og_image')) {
            if ($ogImage) {
                $this->removeUpload($ogImage);
            }
            $ogImage = $this->storeUpload($request->file('og_image'), 'uploads/seo');
        } else {
            $ogImage = $data['og_image_url'] ?? null;
        }

        Setting::many([
            'seo_title_suffix' => $data['title_suffix'],
            'seo_description' => $data['description'],
            'seo_og_image' => $ogImage,
            'seo_verification' => $data['verification'] ?? null,
        ]);

        return redirect()->route('admin.seo.edit')->with('success', 'SEO settings saved.');
    }
}
