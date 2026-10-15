<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic SEO Tags --}}
    <title>@yield('title', 'Shahzad Labs — Engineering Scalable Web Applications & Digital Experiences')</title>
    <meta name="description" content="@yield('meta_description', 'Shahzad Labs is a premier web engineering studio specializing in Laravel, PHP, MySQL, and modern JavaScript. We build high-performance web applications and scalable SaaS platforms.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    {{-- Favicon (Dynamic from Settings) --}}
    <link rel="icon" href="{{ $siteSettings['favicon_url'] }}">

    {{-- OpenGraph Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Shahzad Labs — Scalable Web Applications')">
    <meta property="og:description" content="@yield('meta_description', 'Specializing in Laravel, PHP, MySQL, and modern JavaScript.')">
    <meta property="og:site_name" content="Shahzad Labs">

    {{-- Structured Data --}}
    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": ["ProfessionalService", "Organization"],
        "name": "Shahzad Labs",
        "url": "https://shahzadlabs.com",
        "email": "info@shahzadlabs.com",
        "description": "Professional web development studio specializing in Laravel, PHP, MySQL, and modern JavaScript.",
        "knowsAbout": ["Laravel", "PHP", "MySQL", "JavaScript", "Web Development", "SaaS"]
    }
    </script>
    @endverbatim

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-950 text-surface-200 font-sans antialiased selection:bg-brand-500/30 min-h-screen flex flex-col">

    {{-- Ambient Noise Overlay --}}
    <div class="noise-overlay pointer-events-none"></div>

    {{-- ═══════════════════════════════════════════════════════════════
         NAVBAR
    ═══════════════════════════════════════════════════════════════ --}}
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 border-b border-white/[0.06] bg-surface-950/80 backdrop-blur-xl transition-all duration-300">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
            {{-- Logo with Dynamic Image (Round Shape) --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full overflow-hidden border border-brand-500/40 ring-2 ring-brand-500/20 bg-surface-900 transition-all duration-300 group-hover:ring-brand-400/50 shadow-md">
                    <img src="{{ $siteSettings['site_logo_url'] }}" alt="Logo" class="w-full h-full object-cover rounded-full">
                </div>
                <span class="font-display text-lg font-bold text-white tracking-tight">Shahzad<span class="text-brand-400">Labs</span></span>
            </a>

            {{-- Desktop Navigation (Separate Dedicated Pages) --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('home') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Overview
                </a>
                <a href="{{ route('projects.index') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('projects.*') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Projects
                </a>
                <a href="{{ route('skills.index') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('skills.*') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Tech Stack
                </a>
                <a href="{{ route('services.index') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('services.*') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Services
                </a>
                <a href="{{ route('contact.index') }}"
                   class="px-3.5 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('contact.*') ? 'text-white bg-white/[0.08] shadow-sm' : 'text-surface-200/70 hover:text-white hover:bg-white/[0.04]' }}">
                    Contact
                </a>
            </div>

            {{-- CTA Button + Mobile Toggle --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('contact.index') }}" class="hidden sm:inline-flex btn-primary !py-2 !px-4 !text-xs items-center gap-1.5 shadow-md">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Hire Us / Get Quote
                </a>

                {{-- Mobile Hamburger --}}
                <button id="mobile-nav-toggle" class="md:hidden p-2 rounded-xl text-surface-200 hover:bg-white/[0.06] transition-colors" aria-label="Toggle navigation">
                    <svg class="icon-open w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="icon-close w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </nav>

        {{-- Mobile Drawer Menu --}}
        <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-surface-900/95 backdrop-blur-2xl border-l border-white/[0.08] transform translate-x-full transition-transform duration-300 ease-out md:hidden z-50">
            <div class="flex flex-col gap-2 p-6 pt-20">
                <div class="text-[10px] uppercase font-semibold text-surface-200/40 px-3 mb-1">Navigation</div>
                <a href="{{ route('home') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('home') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Overview</a>
                <a href="{{ route('projects.index') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('projects.*') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Projects</a>
                <a href="{{ route('skills.index') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('skills.*') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Tech Stack</a>
                <a href="{{ route('services.index') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('services.*') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Services</a>
                <a href="{{ route('contact.index') }}" class="px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('contact.*') ? 'bg-brand-500/15 text-brand-400 font-bold' : 'text-surface-200 hover:text-white hover:bg-white/[0.06]' }}">Contact</a>
                <div class="mt-4 pt-4 border-t border-white/[0.08]">
                    <a href="{{ route('contact.index') }}" class="btn-primary w-full !text-xs justify-center">Hire Us / Get Quote</a>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Overlay Backdrop --}}
    <div id="mobile-overlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 hidden md:hidden"></div>

    {{-- Main View Body --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ═══════════════════════════════════════════════════════════════
         GLOBAL FOOTER
    ═══════════════════════════════════════════════════════════════ --}}
    <footer class="border-t border-white/[0.08] bg-surface-950 mt-auto">
        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 mb-8 pb-8 border-b border-white/[0.06]">
                {{-- Brand Column --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-500/15 ring-1 ring-brand-500/30">
                            <svg class="h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <span class="font-display text-base font-bold text-white">Shahzad<span class="text-brand-400">Labs</span></span>
                    </div>
                    <p class="text-xs text-surface-200/50 leading-relaxed">
                        Engineering scalable web applications, robust RESTful APIs, and modern SaaS platforms with Laravel, PHP, MySQL, and modern JavaScript.
                    </p>
                </div>

                {{-- Quick Pages --}}
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-white mb-3">Pages</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="text-surface-200/60 hover:text-white transition-colors">Overview</a></li>
                        <li><a href="{{ route('projects.index') }}" class="text-surface-200/60 hover:text-white transition-colors">Portfolio Projects</a></li>
                        <li><a href="{{ route('skills.index') }}" class="text-surface-200/60 hover:text-white transition-colors">Tech Stack & Skills</a></li>
                        <li><a href="{{ route('services.index') }}" class="text-surface-200/60 hover:text-white transition-colors">Services & Offerings</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-surface-200/60 hover:text-white transition-colors">Contact Hub</a></li>
                    </ul>
                </div>

                {{-- Expertise --}}
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-white mb-3">Core Expertise</h3>
                    <ul class="space-y-2 text-xs text-surface-200/60">
                        <li>Laravel MVC Framework</li>
                        <li>High-Performance MySQL</li>
                        <li>Modern JavaScript & ES6+</li>
                        <li>Tailwind CSS & Responsive UI</li>
                        <li>RESTful API Architecture</li>
                    </ul>
                </div>

                {{-- Direct Contact & Admin --}}
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-white mb-3">Inquiries</h3>
                    <div class="space-y-2 text-xs">
                        <p class="text-surface-200/50">Direct Email:</p>
                        <a href="mailto:info@shahzadlabs.com" class="text-brand-400 font-mono hover:text-brand-300 transition-colors">info@shahzadlabs.com</a>
                        <div class="pt-3">
                            <a href="{{ route('login') }}" class="text-[11px] text-surface-200/40 hover:text-surface-200/80 transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Admin Portal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom copyright --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-surface-200/40">
                <p>&copy; {{ date('Y') }} Shahzad Labs (shahzadlabs.com). All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('sitemap') }}" class="hover:text-surface-200/70 transition-colors">Sitemap XML</a>
                    <span>&bull;</span>
                    <span>Built with Laravel &amp; Tailwind CSS</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- Toast Notification Container --}}
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3"></div>

</body>
</html>
