@extends('layouts.admin')

@section('title', 'Dashboard')
@section('eyebrow', 'Overview')

@section('content')
    @php($chartMax = max(1, max(array_column($messagesByMonth, 'value'))))

    <section class="stat-grid">
        @foreach($stats as $stat)
            <a class="stat-card" href="{{ route($stat['route']) }}">
                <div class="stat-top">
                    <span class="stat-icon {{ $stat['tone'] }}"><x-admin.icon :name="$stat['icon']" /></span>
                    <span class="stat-arrow"><x-admin.icon name="arrow-right" /></span>
                </div>
                <div>
                    <div class="stat-value">{{ $stat['value'] }}</div>
                    <div class="stat-label">{{ $stat['label'] }}</div>
                    <div class="stat-detail">{{ $stat['detail'] }}</div>
                </div>
            </a>
        @endforeach
    </section>

    <div class="eyebrow section-label section-gap">Quick actions</div>

    <section class="quick-grid">
        <a class="quick-action" href="{{ route('admin.projects.create') }}">
            <span class="stat-icon coral"><x-admin.icon name="folder" /></span>
            <span>New Project<small>Create a case study</small></span>
        </a>
        <a class="quick-action" href="{{ route('admin.posts.create') }}">
            <span class="stat-icon teal"><x-admin.icon name="file" /></span>
            <span>New Post<small>Write an article</small></span>
        </a>
        <a class="quick-action" href="{{ route('admin.skills.create') }}">
            <span class="stat-icon amber"><x-admin.icon name="code" /></span>
            <span>Add Skill<small>Grow your skillset</small></span>
        </a>
        <a class="quick-action" href="{{ route('admin.services.create') }}">
            <span class="stat-icon coral"><x-admin.icon name="briefcase" /></span>
            <span>Add Service<small>List what you offer</small></span>
        </a>
        <a class="quick-action" href="{{ route('admin.experiences.create') }}">
            <span class="stat-icon teal"><x-admin.icon name="activity" /></span>
            <span>Add Experience<small>Extend your timeline</small></span>
        </a>
        <a class="quick-action" href="{{ route('admin.contact-messages.index') }}">
            <span class="stat-icon amber"><x-admin.icon name="mail" /></span>
            <span>Messages<small>{{ $unreadMessages }} unread waiting</small></span>
        </a>
    </section>

    @if(! $hasContent)
        <div class="section-gap">
            <div class="card">
                <x-admin.empty
                    title="Your portfolio is empty"
                    text="Start by adding your first project, skill or service — everything you publish here appears on your live site."
                    icon="folder"
                    :action-href="route('admin.projects.create')"
                    action-label="Add your first project"
                />
            </div>
        </div>
    @endif

    <section class="section-gap">
        <x-admin.card title="Recent projects" subtitle="The latest case studies you have been working on" :flush="true">
            <x-slot:actions>
                <a class="link-more" href="{{ route('admin.projects.index') }}">View all <x-admin.icon name="arrow-right" /></a>
            </x-slot:actions>

            @if($recentProjects->isEmpty())
                <x-admin.empty
                    title="No projects yet"
                    text="Projects you create will be listed here with a quick edit shortcut."
                    icon="folder"
                    :action-href="route('admin.projects.create')"
                    action-label="Create a project"
                />
            @else
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Added</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProjects as $project)
                                <tr>
                                    <td>
                                        <div class="cell-title">
                                            @if($project->image_url)
                                                <img class="thumb" src="{{ filter_var($project->image_url, FILTER_VALIDATE_URL) ? $project->image_url : asset($project->image_url) }}" alt="{{ $project->name }}">
                                            @else
                                                <span class="thumb-fallback"><x-admin.icon name="image" /></span>
                                            @endif
                                            <span>
                                                <strong>{{ $project->name }}</strong>
                                                <span class="sub">{{ $project->year ?? '—' }}</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $project->category ?: '—' }}</td>
                                    <td><x-admin.badge :tone="$project->published ? 'live' : 'draft'" :label="$project->published ? 'Published' : 'Draft'" /></td>
                                    <td class="mono-cell">{{ $project->created_at?->format('M j, Y') ?? '—' }}</td>
                                    <td>
                                        <div class="cell-actions">
                                            <a class="row-btn" href="{{ route('admin.projects.edit', $project) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" data-confirm="This project will be permanently removed from your portfolio.">
                                                @csrf
                                                @method('DELETE')
                                                <button class="row-btn is-danger" type="submit" title="Delete"><x-admin.icon name="trash" /></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-admin.card>
    </section>

    <section class="section-gap grid-2">
        <x-admin.card title="Recent messages" subtitle="Latest notes from your contact form" :flush="true">
            <x-slot:actions>
                <a class="link-more" href="{{ route('admin.contact-messages.index') }}">View all <x-admin.icon name="arrow-right" /></a>
            </x-slot:actions>

            @if($recentMessages->isEmpty())
                <x-admin.empty
                    title="No messages yet"
                    text="Messages sent through your contact form will land here."
                    icon="inbox"
                    :action-href="route('home')"
                    action-label="View your website"
                />
            @else
                <div class="msg-list">
                    @foreach($recentMessages as $message)
                        <a class="msg-item" href="{{ route('admin.contact-messages.show', $message) }}">
                            <span class="avatar-fallback">{{ strtoupper(substr($message->name, 0, 1)) }}</span>
                            <span class="who">
                                <strong>{{ $message->name }}</strong>
                                <span class="subject">{{ $message->subject ?: 'No subject' }}</span>
                                <span>{{ $message->email }}</span>
                            </span>
                            @if($message->isUnread())
                                <x-admin.badge tone="unread" label="Unread" />
                            @endif
                            <span class="when">{{ $message->created_at->diffForHumans(['short' => true, 'parts' => 1]) }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </x-admin.card>

        <div class="stack">
            <x-admin.card title="Messages" subtitle="Last six months">
                <div class="chart-bars">
                    @foreach($messagesByMonth as $month)
                        @php($height = $month['value'] > 0 ? max(6, (int) round($month['value'] / $chartMax * 100)) : 0)
                        <div class="chart-col">
                            <div class="chart-bar-track">
                                <div
                                    class="chart-bar @if($month['value'] === 0) is-zero @endif"
                                    data-chart-bar
                                    data-height="{{ $height }}"
                                    data-value="{{ $month['value'] }}"
                                    style="height: 0%"
                                ></div>
                            </div>
                            <span class="chart-label">{{ $month['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </x-admin.card>

            <x-admin.card title="Content breakdown" subtitle="What your portfolio is made of">
                <div class="hbar-list">
                    @foreach($contentBreakdown as $row)
                        <div class="hbar-row">
                            <a class="hbar-label" href="{{ route($row['route']) }}">{{ $row['label'] }}</a>
                            <div class="hbar-track">
                                <div class="hbar-fill {{ $row['tone'] === 'coral' ? '' : $row['tone'] }}" data-hbar="{{ $row['percent'] }}" style="width: 0%"></div>
                            </div>
                            <span class="hbar-value">{{ $row['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </x-admin.card>
        </div>
    </section>
@endsection
