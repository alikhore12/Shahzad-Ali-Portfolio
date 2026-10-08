@php($certification = $certification ?? null)

<form method="POST" action="{{ $action }}" data-loading>
    @csrf
    @if($method ?? null)@method($method)@endif

    <div class="card">
        <div class="card-body">
            <div class="form-grid">
                <x-admin.input name="name" label="Certification name" :value="$certification?->name" placeholder="e.g. Laravel Certified Developer" required />

                <x-admin.input name="issuer" label="Issuer" :value="$certification?->issuer" placeholder="e.g. Laravel" optional />

                <x-admin.input name="year" label="Year" :value="$certification?->year" placeholder="2026" hint="Four digits" optional />

                <x-admin.input name="url" label="Verification URL" :value="$certification?->url" placeholder="https://…" optional />

                <x-admin.input name="sort_order" label="Sort order" type="number" :value="$certification?->sort_order ?? 0" hint="Lower numbers appear first" optional />

                <div class="full">
                    <x-admin.switch name="published" label="Visible" hint="Show this certification on your site" :checked="$certification ? (bool) $certification->published : true" />
                </div>
            </div>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">{{ $certification ? 'Save changes' : 'Add certification' }}</x-admin.btn>
                <x-admin.btn href="{{ route('admin.certifications.index') }}" variant="ghost">Cancel</x-admin.btn>
            </div>
        </div>
    </div>
</form>
