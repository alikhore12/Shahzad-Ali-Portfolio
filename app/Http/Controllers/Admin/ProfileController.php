<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        $profile = Profile::first() ?? new Profile(['name' => setting('site_name', 'Shahzad Ali')]);

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'title' => ['nullable', 'string', 'max:150'],
            'bio' => ['nullable', 'string', 'max:4000'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:60'],
            'location' => ['nullable', 'string', 'max:150'],
            'country' => ['nullable', 'string', 'max:100'],
            'availability' => ['nullable', 'string', 'max:300'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $profile = Profile::first() ?? new Profile;

        if ($request->hasFile('image')) {
            if ($profile->image_path) {
                $this->removeUpload($profile->image_path);
            }
            $data['image_path'] = $this->storeUpload($request->file('image'), 'uploads/profile');
        }

        $profile->fill($data);
        $profile->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
