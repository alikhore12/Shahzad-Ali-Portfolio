@extends('layouts.admin')

@section('title', 'Website Settings')
@section('eyebrow', 'Settings')

@section('content')
    <x-admin.page-head title="Website settings" eyebrow="Settings" subtitle="Global identity, contact and footer copy for your site." />

    <div class="stack">
        <form method="POST" action="{{ route('admin.settings.update') }}" data-loading>
            @csrf
            @method('PUT')

            <x-admin.card title="Site identity">
                <div class="form-grid">
                    <x-admin.input name="site_name" label="Site name" :value="$settings['site_name']" required />

                    <x-admin.input name="contact_email" label="Contact email" type="email" :value="$settings['contact_email']" required />

                    <div class="full">
                        <x-admin.input name="site_tagline" label="Tagline" :value="$settings['site_tagline']" required />
                    </div>

                    <x-admin.input name="footer_tagline" label="Footer tagline" :value="$settings['footer_tagline']" required />

                    <x-admin.input name="availability_note" label="Availability note" :value="$settings['availability_note']" required />
                </div>

                <div class="form-actions">
                    <x-admin.btn type="submit" icon="check">Save settings</x-admin.btn>
                </div>
            </x-admin.card>
        </form>

        <x-admin.card title="Social links" subtitle="Shown in your site footer" :flush="true">
            <div class="card-body">
                @forelse($socialLinks as $link)
                    <div class="social-row">
                        <form method="POST" action="{{ route('admin.social-links.update', $link) }}" class="social-form" data-loading>
                            @csrf
                            @method('PUT')
                            <input class="form-control" name="platform" value="{{ $link->platform }}" placeholder="Platform" aria-label="Platform" required>
                            <input class="form-control" name="url" value="{{ $link->url }}" placeholder="https://github.com/…" aria-label="URL" required>
                            <input class="form-control" name="sort_order" type="number" value="{{ $link->sort_order }}" aria-label="Sort order">
                            <label class="switch" title="Visible on site">
                                <input type="checkbox" name="published" value="1" @checked($link->published) aria-label="Visible">
                                <span></span>
                            </label>
                            <x-admin.btn type="submit" variant="secondary" size="sm">Save</x-admin.btn>
                        </form>

                        <form method="POST" action="{{ route('admin.social-links.destroy', $link) }}" data-confirm="Remove the {{ $link->platform }} link from your footer?">
                            @csrf
                            @method('DELETE')
                            <button class="row-btn is-danger" type="submit" title="Delete"><x-admin.icon name="trash" /></button>
                        </form>
                    </div>
                @empty
                    <p class="muted">No social links yet — add your first one below.</p>
                @endforelse
            </div>

            <form method="POST" action="{{ route('admin.social-links.store') }}" class="filter-bar" data-loading>
                @csrf
                <input class="form-control" name="platform" placeholder="Platform (e.g. GitHub)" style="max-width: 220px;" required>
                <input class="form-control" name="url" placeholder="https://…" style="flex: 1; min-width: 220px;" required>
                <input class="form-control" name="sort_order" type="number" value="0" title="Sort order" style="max-width: 90px;">
                <x-admin.btn type="submit" icon="plus">Add link</x-admin.btn>
            </form>
        </x-admin.card>
    </div>
@endsection
