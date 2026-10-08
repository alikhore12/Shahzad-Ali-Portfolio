@php
    $project = $project ?? null;
    $tagsValue = is_array($project?->tags) ? implode("\n", $project->tags) : (string) ($project?->tags ?? '');
    $featuresValue = is_array($project?->features) ? implode("\n", $project->features) : (string) ($project?->features ?? '');
@endphp

<form method="POST" action="{{ $action }}" data-loading enctype="multipart/form-data">
    @csrf
    @if($method ?? null)@method($method)@endif

    <div class="card">
        <div class="card-body">
            <div class="form-grid">
                <x-admin.input name="name" label="Project name" :value="$project?->name" placeholder="e.g. CV Builder" required />

                <x-admin.input name="slug" label="Slug" :value="$project?->slug" placeholder="auto-generated from the name" hint="URL: /portfolio/your-slug" optional />

                <x-admin.input name="category" label="Category" :value="$project?->category" placeholder="e.g. Web App" required />

                <x-admin.input name="year" label="Year" :value="$project?->year" placeholder="2026" hint="Four digits" optional />

                <x-admin.select name="accent" label="Accent colour" :value="$project?->accent ?? 'coral'" :options="['coral' => 'Coral (default)', 'teal' => 'Teal', 'amber' => 'Amber']" />

                <x-admin.input name="github_url" label="GitHub URL" :value="$project?->github_url" placeholder="https://github.com/…" optional />

                <x-admin.textarea name="description" label="Short description" :value="$project?->description" :rows="3" placeholder="One or two sentences shown on cards" required />

                <x-admin.textarea name="body" label="Full story" :value="$project?->body" :rows="8" placeholder="The long-form case study content (markdown-free HTML is not required — plain text with paragraphs)" optional />

                <x-admin.textarea name="tags" label="Tags" :value="$tagsValue" :rows="3" placeholder="Laravel&#10;Tailwind&#10;REST API" hint="One tag per line" optional />

                <x-admin.textarea name="features" label="Key features" :value="$featuresValue" :rows="3" placeholder="Drag and drop uploads&#10;Role-based access" hint="One feature per line" optional />

                <x-admin.input name="live_url" label="Live URL" :value="$project?->live_url" placeholder="https://shahzadlabs.com" optional />

                <x-admin.upload name="image" label="Cover image" :current="$project?->image_url" />

                <div class="full">
                    <x-admin.switch name="published" label="Published" hint="Visible on your public portfolio when on" :checked="$project ? (bool) $project->published : true" />
                </div>
            </div>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">{{ $project ? 'Save changes' : 'Create project' }}</x-admin.btn>
                <x-admin.btn href="{{ route('admin.projects.index') }}" variant="ghost">Cancel</x-admin.btn>
            </div>
        </div>
    </div>
</form>
