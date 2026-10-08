<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ route('profile.favicon') }}">
    <title>@yield('title', 'Dashboard') · {{ setting('site_name', 'Shahzad Ali') }} Admin</title>

    @php
        $manifestPath = public_path('build/manifest.json');
        $manifest = is_file($manifestPath) ? json_decode((string) file_get_contents($manifestPath), true) : [];
        $hasAdminBuild = is_array($manifest) && isset($manifest['resources/css/admin.css'], $manifest['resources/js/admin.js']);
    @endphp

    @if($hasAdminBuild)
        @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @else
        <link rel="stylesheet" href="{{ route('admin.assets.css') }}">
        <script src="{{ route('admin.assets.js') }}" defer></script>
    @endif

    @stack('head')
</head>
<body>
@php
    $adminUser = auth()->user();
    $profile = \App\Models\Profile::first();
    $avatarPath = $profile?->image_path;
    $unreadCount = \App\Models\ContactMessage::whereNull('read_at')->count();

    $navGroups = [
        ['label' => null, 'items' => [
            ['label' => 'Dashboard', 'icon' => 'grid', 'match' => 'admin.dashboard', 'href' => route('admin.dashboard')],
        ]],
        ['label' => 'Portfolio', 'items' => [
            ['label' => 'Profile', 'icon' => 'user', 'match' => 'admin.profile.*', 'href' => route('admin.profile.edit')],
            ['label' => 'About', 'icon' => 'info', 'match' => 'admin.about.*', 'href' => route('admin.about.edit')],
            ['label' => 'Skills', 'icon' => 'code', 'match' => 'admin.skills.*', 'href' => route('admin.skills.index')],
            ['label' => 'Services', 'icon' => 'briefcase', 'match' => 'admin.services.*', 'href' => route('admin.services.index')],
            ['label' => 'Projects', 'icon' => 'folder', 'match' => 'admin.projects.*', 'href' => route('admin.projects.index')],
        ]],
        ['label' => 'Journey', 'items' => [
            ['label' => 'Experience', 'icon' => 'activity', 'match' => 'admin.experiences.*', 'href' => route('admin.experiences.index')],
            ['label' => 'Education', 'icon' => 'graduation', 'match' => 'admin.education.*', 'href' => route('admin.education.index')],
            ['label' => 'Certifications', 'icon' => 'award', 'match' => 'admin.certifications.*', 'href' => route('admin.certifications.index')],
        ]],
        ['label' => 'Content', 'items' => [
            ['label' => 'Testimonials', 'icon' => 'star', 'match' => 'admin.testimonials.*', 'href' => route('admin.testimonials.index')],
            ['label' => 'Blog / Articles', 'icon' => 'file', 'match' => 'admin.posts.*', 'href' => route('admin.posts.index')],
            ['label' => 'Contact Messages', 'icon' => 'mail', 'match' => 'admin.contact-messages.*', 'href' => route('admin.contact-messages.index'), 'count' => $unreadCount],
        ]],
        ['label' => 'Settings', 'items' => [
            ['label' => 'SEO Settings', 'icon' => 'search', 'match' => 'admin.seo.*', 'href' => route('admin.seo.edit')],
            ['label' => 'Website Settings', 'icon' => 'globe', 'match' => 'admin.settings.*', 'href' => route('admin.settings.edit')],
        ]],
    ];

    $searchIndex = collect($navGroups)
        ->flatMap(fn ($group) => $group['items'])
        ->map(fn ($item) => ['label' => $item['label'], 'href' => $item['href']])
        ->values()
        ->all();
@endphp

<div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-backdrop></div>

    <aside class="admin-sidebar" data-sidebar>
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-mark">✳</span>
            <span class="sidebar-brand-text">
                <strong>{{ setting('site_name', 'Shahzad Ali') }}</strong>
                <span>Admin panel</span>
            </span>
        </a>

        <nav class="sidebar-nav" aria-label="Admin navigation">
            @foreach($navGroups as $group)
                <div class="nav-group">
                    @if($group['label'])<div class="nav-group-label">{{ $group['label'] }}</div>@endif
                    @foreach($group['items'] as $item)
                        <a href="{{ $item['href'] }}" @class(['nav-item' => true, 'active' => request()->routeIs($item['match'])])>
                            <x-admin.icon :name="$item['icon']" />
                            <span>{{ $item['label'] }}</span>
                            @if(! empty($item['count']))
                                <span class="nav-count">{{ $item['count'] }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        </nav>

        <div class="sidebar-foot">
            <a class="sidebar-user" href="{{ route('admin.profile.edit') }}">
                @if($avatarPath)
                    <img class="avatar" src="{{ filter_var($avatarPath, FILTER_VALIDATE_URL) ? $avatarPath : asset($avatarPath) }}" alt="">
                @else
                    <span class="avatar-fallback">{{ strtoupper(substr($adminUser->name ?? 'A', 0, 1)) }}</span>
                @endif
                <span class="sidebar-user-meta">
                    <strong>{{ $profile?->name ?? $adminUser->name }}</strong>
                    <span>{{ $adminUser->email }}</span>
                </span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item sidebar-logout">
                    <x-admin.icon name="logout" />
                    <span>Log out</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-header">
            <button type="button" class="icon-btn menu-toggle" data-sidebar-toggle aria-label="Toggle navigation">
                <x-admin.icon name="menu" />
            </button>

            <div class="header-title-wrap">
                <span class="header-crumb">@yield('eyebrow', 'Admin panel')</span>
                <div class="header-title">@yield('title', 'Dashboard')</div>
            </div>

            <div class="header-spacer"></div>

            <div class="header-search">
                <x-admin.icon name="search" />
                <input type="search" placeholder="Jump to a section…" data-search-input aria-label="Search sections">
                <kbd>Ctrl K</kbd>
                <div class="search-results" data-search-results></div>
            </div>

            <a class="icon-btn" href="{{ route('admin.contact-messages.index') }}" title="{{ $unreadCount }} unread messages" aria-label="Notifications">
                <x-admin.icon name="bell" />
                @if($unreadCount)<span class="bell-dot">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>@endif
            </a>

            <div class="dropdown" data-dropdown>
                <button type="button" class="profile-trigger" aria-haspopup="true">
                    @if($avatarPath)
                        <img class="avatar" src="{{ filter_var($avatarPath, FILTER_VALIDATE_URL) ? $avatarPath : asset($avatarPath) }}" alt="">
                    @else
                        <span class="avatar-fallback">{{ strtoupper(substr($adminUser->name ?? 'A', 0, 1)) }}</span>
                    @endif
                    <span class="name">{{ $adminUser->name }}</span>
                    <x-admin.icon name="chevron-down" class="chev" />
                </button>

                <div class="dropdown-menu">
                    <div class="dropdown-head">
                        <strong>{{ $adminUser->name }}</strong>
                        <span>{{ $adminUser->email }}</span>
                    </div>
                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><x-admin.icon name="user" />Profile</a>
                    <a class="dropdown-item" href="{{ route('home') }}" target="_blank" rel="noopener"><x-admin.icon name="external" />View website</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item is-danger"><x-admin.icon name="logout" />Log out</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="admin-content">
            @yield('content')
        </main>
    </div>
</div>

<div class="toast-stack" data-toasts>
    @if(session('success'))
        <div class="toast" role="status">
            <span class="toast-icon"><x-admin.icon name="check" /></span>
            <div class="toast-body"><strong>Done</strong><p>{{ session('success') }}</p></div>
            <button class="toast-close" type="button" aria-label="Dismiss"><x-admin.icon name="x" /></button>
        </div>
    @endif

    @if(session('error'))
        <div class="toast is-error" role="status">
            <span class="toast-icon"><x-admin.icon name="x" /></span>
            <div class="toast-body"><strong>Something went wrong</strong><p>{{ session('error') }}</p></div>
            <button class="toast-close" type="button" aria-label="Dismiss"><x-admin.icon name="x" /></button>
        </div>
    @endif

    @if(session('status') && is_string(session('status')))
        <div class="toast is-info" role="status">
            <span class="toast-icon"><x-admin.icon name="info" /></span>
            <div class="toast-body"><strong>Notice</strong><p>{{ session('status') }}</p></div>
            <button class="toast-close" type="button" aria-label="Dismiss"><x-admin.icon name="x" /></button>
        </div>
    @endif
</div>

<div class="modal-backdrop" data-confirm-box role="dialog" aria-modal="true" aria-labelledby="confirm-title">
    <div class="modal">
        <span class="modal-icon"><x-admin.icon name="alert" /></span>
        <h3 id="confirm-title" data-confirm-title>Delete this item?</h3>
        <p data-confirm-text>This action cannot be undone.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" data-confirm-cancel>Cancel</button>
            <button type="button" class="btn btn-danger" data-confirm-accept>Yes, continue</button>
        </div>
    </div>
</div>

<script>window.ADMIN_SEARCH_INDEX = @json($searchIndex);</script>
@stack('scripts')
</body>
</html>
