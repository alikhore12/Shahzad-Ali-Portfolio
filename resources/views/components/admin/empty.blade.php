@props(['title' => 'Nothing here yet', 'text' => null, 'icon' => 'folder', 'actionHref' => null, 'actionLabel' => 'Add your first entry'])

<div class="empty-state">
    <span class="empty-icon"><x-admin.icon :name="$icon" /></span>
    <h3>{{ $title }}</h3>
    <p>{{ $text ?? 'Once you add content it will show up here and on your live portfolio.' }}</p>
    @if($actionHref)
        <a href="{{ $actionHref }}" class="btn btn-primary"><x-admin.icon name="plus" />{{ $actionLabel }}</a>
    @endif
</div>
