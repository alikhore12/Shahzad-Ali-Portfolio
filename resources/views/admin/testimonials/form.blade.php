@php($testimonial = $testimonial ?? null)

<form method="POST" action="{{ $action }}" data-loading>
    @csrf
    @if($method ?? null)@method($method)@endif

    <div class="card">
        <div class="card-body">
            <div class="form-grid">
                <x-admin.input name="name" label="Name" :value="$testimonial?->name" placeholder="e.g. Sara Khan" required />

                <x-admin.input name="role" label="Role" :value="$testimonial?->role" placeholder="e.g. Product Manager, Nexa Labs" optional />

                <x-admin.select name="rating" label="Rating" :value="$testimonial?->rating ?? 5" :options="[5 => '5 — Excellent', 4 => '4 — Great', 3 => '3 — Good', 2 => '2 — Fair', 1 => '1 — Poor']" />

                <x-admin.input name="sort_order" label="Sort order" type="number" :value="$testimonial?->sort_order ?? 0" hint="Lower numbers appear first" optional />

                <div class="full">
                    <x-admin.textarea name="quote" label="Quote" :value="$testimonial?->quote" :rows="4" placeholder="What they said about working with you" required />
                </div>

                <div class="full">
                    <x-admin.switch name="published" label="Showing" hint="Display this testimonial on your site" :checked="$testimonial ? (bool) $testimonial->published : true" />
                </div>
            </div>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">{{ $testimonial ? 'Save changes' : 'Add testimonial' }}</x-admin.btn>
                <x-admin.btn href="{{ route('admin.testimonials.index') }}" variant="ghost">Cancel</x-admin.btn>
            </div>
        </div>
    </div>
</form>
