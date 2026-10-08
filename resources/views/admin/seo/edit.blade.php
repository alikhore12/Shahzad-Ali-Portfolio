@extends('layouts.admin')

@section('title', 'SEO')
@section('eyebrow', 'Settings')

@section('content')
    <x-admin.page-head title="SEO settings" eyebrow="Settings" subtitle="Search and social sharing defaults for your site." />

    <form method="POST" action="{{ route('admin.seo.update') }}" data-loading enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="og_image_url" value="{{ old('og_image_url', $seo['og_image']) }}">

        <div class="grid-3-2">
            <x-admin.card title="Search">
                <div class="form-grid">
                    <div class="full">
                        <x-admin.input name="title_suffix" label="Title suffix" :value="$seo['title_suffix']" hint="Appended to page titles, e.g. “| Shahzad Ali”" required />
                    </div>

                    <div class="full">
                        <x-admin.textarea name="description" label="Meta description" :value="$seo['description']" :rows="3" hint="Shown in search results — aim for 140–160 characters" required />
                    </div>

                    <div class="full">
                        <x-admin.input name="verification" label="Search engine verification" :value="$seo['verification']" placeholder="Google site verification token" optional />
                    </div>
                </div>
            </x-admin.card>

            <div class="stack">
                <x-admin.card title="Social preview">
                    <p class="muted">Shown when your site is shared on social media and in link previews.</p>
                    <div style="margin-top: 16px;">
                        <x-admin.upload name="og_image" label="Share image" :current="$seo['og_image']" hint="1200 × 630 works best" :optional="true" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Tips">
                    <div class="info-list">
                        <div class="info-item">
                            <span>Title</span>
                            <strong>Keep it under 60 characters so it is not cut off.</strong>
                        </div>
                        <div class="info-item">
                            <span>Description</span>
                            <strong>Write it like a promise, not a keyword list.</strong>
                        </div>
                        <div class="info-item">
                            <span>Image</span>
                            <strong>Use a clear, bright image with your name or work.</strong>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="form-actions">
            <x-admin.btn type="submit" icon="check">Save SEO settings</x-admin.btn>
        </div>
    </form>
@endsection
