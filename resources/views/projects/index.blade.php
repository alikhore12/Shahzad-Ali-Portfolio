<x-app-layout>

@section('header', '<h1 class="text-3xl font-bold tracking-tight text-gray-900">Work That Speaks</h1>
<p class="text-lg text-gray-600 mt-2">A selection of projects I've built for startups, enterprises, and my own ventures. Each one designed to solve real problems.</h1>')

@section('content')

<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <!-- Category Filter Tabs -->
    <div class="mb-12 sm:mb-16">
        <div class="flex flex-wrap gap-2" x-data="{ active: 'all' }">
            <button
                x-on:click="active = 'all'"
                :class="active === 'all'
                    ? 'inline-flex items-center rounded-md bg-primary text-primary-foreground px-4 py-2 text-sm font-medium shadow-sm'
                    : 'inline-flex items-center rounded-md border border-gray-300 text-gray-600 px-4 py-2 text-sm font-medium shadow-sm hover:bg-gray-50'"
                aria-pressed="true"
            >
                All Projects
            </button>

            @foreach (['case_study', 'client_work', 'enterprise', 'seo_tools', 'personal'] as $category)
                <button
                    x-on:click="active = '{{ $category }}'"
                    :class="active === '{{ $category }}'
                        ? 'inline-flex items-center rounded-md bg-primary text-primary-foreground px-4 py-2 text-sm font-medium shadow-sm'
                        : 'inline-flex items-center rounded-md border border-gray-300 text-gray-600 px-4 py-2 text-sm font-medium shadow-hover:bg-gray-50'"
                >
                    {{ ucfirst($category) }}
                </button>
            @endforeach

            <button
                x-on:click="active = 'all'"
                :class="active === 'all'
                    ? 'inline-flex items-center rounded-md bg-primary text-primary-foreground px-4 py-2 text-sm font-medium shadow-sm'
                    : 'inline-flex items-center rounded-md border border-gray-300 text-gray-600 px-4 py-2 text-sm font-medium shadow-sm hover:bg-gray-50'"
            >
                All
            </button>
        </div>
    </div>

    <!-- Project Grid -->
    <div class="grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="active === 'all' || active === 'case_study'" x-transition:duration="200ms">

        @php $featuredProjects = collect($projects)->where('is_featured', true)->take(4)->values()->all()}

        @if (active === 'all' || active === 'case_study')
            @foreach ($projects as $project)
                <article
                    class="group bg-card border border-border rounded-lg p-6 hover:shadow-md hover transition-shadow duration-300
                           @if($loop->first && ! $loop->iteration % 2 == 0)
                               opacity-0 translate-y-2
                           @endif"
                    x-transition:opacity="200ms"
                    x-transition:transform="200ms"
                >
                    {{-- Thumbnail with hover effect --}}
                    <div class="relative h-48 mb-4 rounded-lg overflow-hidden group-hover:opacity-90 group-hover transition-opacity">
                        @if($project->banner_image_url)
                            <img
                                src="{{ $project->banner_image_url }}"
                                alt="{{ $project->title }} banner"
                                class="absolute inset-0 w-full h-full object-cover"
                            />
                        @elseif($project->thumbnail_url)
                            <img
                                src="{{ $project->thumbnail_url }}"
                                alt="{{ $project->title }} thumbnail"
                                class="absolute inset-0 w-full h-full object-cover"
                            />
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center">
                                <span class="text-primary font-medium">{{ Str::limit($project->title, 20) }}</span>
                            </div>
                        @endif

                        {{-- Category and Featured Badge --}}
                        <div class="absolute top-3 left-3 flex gap-2">
                            {{-- Category Badge --}}
                            <span
                                class="inline-flex items-center rounded-full bg-primary/10 text-primary px-2.5 py-0.5 text-xs font-medium"
                            >
                                {{ ucfirst($project->category) }}
                            </span>

                            {{-- Featured Badge --}}
                            @if($project->is_featured)
                                <span
                                    class="inline-flex items-center rounded-full bg-primary text-primary-foreground px-2.5 py-0.5 text-xs font-semibold"
                                >
                                    Featured
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div>
                        {{-- Pill badges for tech stack --}}
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($project->tech_stack as $tech)
                                <span
                                    class="inline-flex items-center rounded-full border border-border bg-background px-2.5 py-0.5 text-xs font-medium"
                                >
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Project Title --}}
                        <h3 class="text-lg font-medium text-foreground mb-1">
                            <a href="{{ route('projects.show', $project->slug) }}"
                               class="hover:text-primary transition-colors"
                               tabindex="0"
                               aria-label="View project: {{ $project->title }}"
                            >
                                {{ $project->title }}
                            </a>
                        </h3>

                        {{-- Excerpt --}}
                        <p class="text-sm text-muted-foreground line-clamp-2">
                            {{ $project->excerpt }}
                        </p>
                    </div>
                </article>
            @endforeach
        @endif>

    </div>

    {{-- Metrics / Stats Counter Section --}}
    <div class="mt-16 sm:mt-20 grid grid-cols-2 lg:grid-cols-4 gap-4 pt-8 border-t border-border">
        <div class="flex flex-col items-center">
            <div class="text-2xl font-bold text-primary">12+</div>
            <div class="text-sm text-muted-foreground">Projects Delivered</div>
        </div>
        <div class="flex flex-col items-center">
            <div class="text-2xl font-bold text-primary">98%</div>
            <div class="text-sm text-muted-foreground">Client Satisfaction</div>
        </div>
        <div class="flex flex-col items-center">
            <div class="text-2xl font-bold text-primary">99.9%</div>
            <div class="text-sm text-muted-foreground">Uptime Average</div>
        </div>
        <div class="flex flex-col items-center">
            <div class="text-2xl font-bold text-primary">4.8</div>
            <div class="text-sm text-muted-foreground">Star Rating</div>
        </div>
    </div>

    {{-- Call to Action --}}
    <div class="mt-16 sm:mt-24 rounded-lg border p-8 sm:p-12 bg-primary/5 text-primary">
        <div class="flex items-start">
            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-col">
                <svg class="w-5 h-5 text-primary mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path class="stroke-2" d="M8 12l4 4L16 8M5 12h14M8 12a4 4 0 100-8 4 4 0 100 8z"/>
                </svg>
                <span class="text-xs font-medium">Have a Project in Mind?</span>
            </div>
            <div class="ml-4">
                <a href="/contact"
                   class="underline underline-offset-4 hover:text-primary transition-colors"
                   aria-label="Contact me about your project"
                >
                    Let's discuss your project
                </a>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    // Category filtering state
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.category-tab');
        const projectCards = document.querySelectorAll('.project-card');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // Update active state
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const category = this.dataset.category;

                // Filter projects
                projectCards.forEach(card => {
                    const cardCategory = card.dataset.category;

                    if (category === 'all' || cardCategory === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>