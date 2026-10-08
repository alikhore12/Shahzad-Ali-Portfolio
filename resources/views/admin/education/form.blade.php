@php($education = $education ?? null)

<form method="POST" action="{{ $action }}" data-loading>
    @csrf
    @if($method ?? null)@method($method)@endif

    <div class="card">
        <div class="card-body">
            <div class="form-grid">
                <x-admin.input name="institution" label="Institution" :value="$education?->institution" placeholder="e.g. COMSATS University" required />

                <x-admin.input name="degree" label="Degree" :value="$education?->degree" placeholder="e.g. BS Computer Science" required />

                <x-admin.input name="period" label="Period" :value="$education?->period" placeholder="e.g. 2023 — 2027" optional />

                <x-admin.input name="sort_order" label="Sort order" type="number" :value="$education?->sort_order ?? 0" hint="Lower numbers appear first" optional />

                <div class="full">
                    <x-admin.textarea name="description" label="Description" :value="$education?->description" :rows="4" placeholder="Highlights, coursework or achievements" required />
                </div>

                <div class="full">
                    <x-admin.switch name="published" label="Visible" hint="Show this entry on your education section" :checked="$education ? (bool) $education->published : true" />
                </div>
            </div>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">{{ $education ? 'Save changes' : 'Add education' }}</x-admin.btn>
                <x-admin.btn href="{{ route('admin.education.index') }}" variant="ghost">Cancel</x-admin.btn>
            </div>
        </div>
    </div>
</form>
