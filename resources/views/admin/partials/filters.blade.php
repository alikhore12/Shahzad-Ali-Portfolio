@php
    $search = $search ?? request('q');
    $categories = $categories ?? null;
    $statusParam = $statusParam ?? 'status';
    $statusOptions = $statusOptions ?? ['published' => 'Published', 'draft' => 'Draft'];
    $showSearch = $showSearch ?? true;
@endphp

<form method="GET" action="{{ request()->url() }}" data-filter-form class="filter-bar">
    @if($showSearch)
        <div class="search-inline">
            <x-admin.icon name="search" />
            <input type="search" name="q" value="{{ $search }}" placeholder="Search…" aria-label="Search">
        </div>
    @endif

    @if($categories)
        <select class="filter-select" name="category" aria-label="Category">
            <option value="">All categories</option>
            @foreach($categories as $category)
                @if($category)
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                @endif
            @endforeach
        </select>
    @endif

    @if($statusOptions)
        <select class="filter-select" name="{{ $statusParam }}" aria-label="Status">
            <option value="">Any status</option>
            @foreach($statusOptions as $value => $label)
                <option value="{{ $value }}" @selected(request($statusParam) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    @endif

    @if(request('q') || request('category') || request($statusParam))
        <a class="btn btn-ghost btn-sm" href="{{ request()->url() }}">Reset</a>
    @endif
</form>
