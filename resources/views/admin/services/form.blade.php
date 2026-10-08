@php
    $service = $service ?? null;
    $pointsValue = is_array($service?->points) ? implode("\n", $service->points) : (string) ($service?->points ?? '');
@endphp

<form method="POST" action="{{ $action }}" data-loading>
    @csrf
    @if($method ?? null)@method($method)@endif

    <div class="card">
        <div class="card-body">
            <div class="form-grid">
                <x-admin.input name="name" label="Service name" :value="$service?->name" placeholder="e.g. Web Development" required />

                <x-admin.input name="slug" label="Slug" :value="$service?->slug" placeholder="auto-generated from the name" hint="URL: /services/your-slug" optional />

                <div class="full">
                    <x-admin.textarea name="intro" label="One-line intro" :value="$service?->intro" :rows="2" placeholder="A short sentence describing this service" required />
                </div>

                <div class="full">
                    <x-admin.textarea name="details" label="Details" :value="$service?->details" :rows="6" placeholder="What this service includes" optional />
                </div>

                <div class="full">
                    <x-admin.textarea name="points" label="Highlight points" :value="$pointsValue" :rows="4" placeholder="Discovery workshop&#10;Design and build&#10;Launch support" hint="One point per line" optional />
                </div>

                <div class="full">
                    <x-admin.switch name="published" label="Published" hint="Visible on your public services page when on" :checked="$service ? (bool) $service->published : true" />
                </div>
            </div>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">{{ $service ? 'Save changes' : 'Add service' }}</x-admin.btn>
                <x-admin.btn href="{{ route('admin.services.index') }}" variant="ghost">Cancel</x-admin.btn>
            </div>
        </div>
    </div>
</form>
