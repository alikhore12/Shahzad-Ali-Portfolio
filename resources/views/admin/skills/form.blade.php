@php
    $skill = $skill ?? null;
    $pointsValue = is_array($skill?->points) ? implode("\n", $skill->points) : (string) ($skill?->points ?? '');
@endphp

<form method="POST" action="{{ $action }}" data-loading>
    @csrf
    @if($method ?? null)@method($method)@endif

    <div class="card">
        <div class="card-body">
            <div class="form-grid">
                <x-admin.input name="name" label="Skill name" :value="$skill?->name" placeholder="e.g. Laravel" required />

                <x-admin.input name="slug" label="Slug" :value="$skill?->slug" placeholder="auto-generated from the name" hint="URL: /skills/your-slug" optional />

                <x-admin.input name="category" label="Category" :value="$skill?->category" placeholder="e.g. Backend" hint="Groups skills on the public page" required />

                <x-admin.input name="intro" label="One-line intro" :value="$skill?->intro" placeholder="A short sentence about this skill" required />

                <x-admin.textarea name="details" label="Details" :value="$skill?->details" :rows="6" placeholder="Longer description shown on the skill page" optional />

                <x-admin.textarea name="points" label="Highlight points" :value="$pointsValue" :rows="4" placeholder="Built 20+ projects&#10;Used in production daily" hint="One point per line" optional />

                <div class="full">
                    <x-admin.switch name="published" label="Published" hint="Visible on your public skills page when on" :checked="$skill ? (bool) $skill->published : true" />
                </div>
            </div>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">{{ $skill ? 'Save changes' : 'Add skill' }}</x-admin.btn>
                <x-admin.btn href="{{ route('admin.skills.index') }}" variant="ghost">Cancel</x-admin.btn>
            </div>
        </div>
    </div>
</form>
