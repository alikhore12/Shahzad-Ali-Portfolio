@php($experience = $experience ?? null)

<form method="POST" action="{{ $action }}" data-loading>
    @csrf
    @if($method ?? null)@method($method)@endif

    <div class="card">
        <div class="card-body">
            <div class="form-grid">
                <x-admin.input name="title" label="Role title" :value="$experience?->title" placeholder="e.g. Full-stack Developer" required />

                <x-admin.input name="company" label="Company" :value="$experience?->company" placeholder="e.g. Freelance" optional />

                <x-admin.input name="period" label="Period" :value="$experience?->period" placeholder="e.g. 2024 — Present" hint="Shown next to the entry" optional />

                <x-admin.input name="sort_order" label="Sort order" type="number" :value="$experience?->sort_order ?? 0" hint="Lower numbers appear first" optional />

                <div class="full">
                    <x-admin.textarea name="description" label="Description" :value="$experience?->description" :rows="4" placeholder="What you did in this role" required />
                </div>

                <div class="full">
                    <x-admin.switch name="published" label="Visible" hint="Show this entry on your experience page" :checked="$experience ? (bool) $experience->published : true" />
                </div>
            </div>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">{{ $experience ? 'Save changes' : 'Add experience' }}</x-admin.btn>
                <x-admin.btn href="{{ route('admin.experiences.index') }}" variant="ghost">Cancel</x-admin.btn>
            </div>
        </div>
    </div>
</form>
