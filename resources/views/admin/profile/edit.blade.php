@extends('layouts.admin')

@section('title', 'Profile')
@section('eyebrow', 'Settings')

@section('content')
    <x-admin.page-head title="Profile" eyebrow="Settings" subtitle="Your identity across the portfolio — photo, bio and contact details." />

    <form method="POST" action="{{ route('admin.profile.update') }}" data-loading enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid-3-2">
            <div class="stack">
                <x-admin.card title="Identity">
                    <div class="form-grid">
                        <x-admin.input name="name" label="Name" :value="$profile->name" required />

                        <x-admin.input name="title" label="Headline" :value="$profile->title" placeholder="e.g. Full-stack developer" optional />

                        <div class="full">
                            <x-admin.textarea name="bio" label="Bio" :value="$profile->bio" :rows="5" placeholder="A short paragraph about you" optional />
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card title="Contact details">
                    <div class="form-grid">
                        <x-admin.input name="email" label="Email" type="email" :value="$profile->email" optional />

                        <x-admin.input name="phone" label="Phone" :value="$profile->phone" optional />

                        <x-admin.input name="location" label="Location" :value="$profile->location" placeholder="e.g. Lahore, Pakistan" optional />

                        <x-admin.input name="country" label="Country" :value="$profile->country" placeholder="e.g. Pakistan" optional />

                        <x-admin.input name="availability" label="Availability" :value="$profile->availability" placeholder="e.g. Open for freelance work" optional />
                    </div>
                </x-admin.card>

                <div class="form-actions">
                    <x-admin.btn type="submit" icon="check">Save profile</x-admin.btn>
                    <x-admin.btn href="{{ route('home') }}" variant="ghost" icon="external">View site</x-admin.btn>
                </div>
            </div>

            <x-admin.card title="Photo">
                <x-admin.upload name="image" label="Profile photo" :current="$profile->image_path" hint="Square crops look best. PNG, JPG or WEBP up to 4 MB" :optional="true" />
            </x-admin.card>
        </div>
    </form>
@endsection
