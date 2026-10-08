@extends('layouts.admin')

@section('title', 'About')
@section('eyebrow', 'Settings')

@section('content')
    <x-admin.page-head title="About page" eyebrow="Settings" subtitle="The story visitors read on your /about page." />

    <form method="POST" action="{{ route('admin.about.update') }}" data-loading>
        @csrf
        @method('PUT')

        <div class="stack">
            <x-admin.card title="Copy">
                <div class="form-grid">
                    <div class="full">
                        <x-admin.input name="about_title" label="Page headline" :value="$title" required />
                    </div>

                    <div class="full">
                        <x-admin.textarea name="about_intro" label="Intro paragraph" :value="$intro" :rows="4" required />
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Highlight cards" subtitle="Two or three short cards that summarise how you work">
                <div data-cards>
                    @foreach($cards as $index => $card)
                        <div class="card-slot" data-card-slot>
                            <div class="slot-head">
                                <span>Card {{ $index + 1 }}</span>
                                <button type="button" class="slot-remove" data-remove-card title="Remove card"><x-admin.icon name="trash" /></button>
                            </div>
                            <div class="form-grid">
                                <x-admin.input name="cards[{{ $index }}][label]" label="Label" :value="$card['label'] ?? ''" placeholder="01" required />
                                <x-admin.input name="cards[{{ $index }}][title]" label="Title" :value="$card['title'] ?? ''" placeholder="My approach" required />
                                <div class="full">
                                    <x-admin.textarea name="cards[{{ $index }}][text]" label="Text" :value="$card['text'] ?? ''" :rows="3" required />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <template data-card-template>
                    <div class="card-slot" data-card-slot>
                        <div class="slot-head">
                            <span>New card</span>
                            <button type="button" class="slot-remove" data-remove-card title="Remove card"><x-admin.icon name="trash" /></button>
                        </div>
                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label" for="cards___INDEX___label">Label <span class="req">*</span></label>
                                <input class="form-control" id="cards___INDEX___label" name="cards[__INDEX__][label]" value="" placeholder="03" required>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="cards___INDEX___title">Title <span class="req">*</span></label>
                                <input class="form-control" id="cards___INDEX___title" name="cards[__INDEX__][title]" value="" placeholder="What's next" required>
                            </div>
                            <div class="full form-field">
                                <label class="form-label" for="cards___INDEX___text">Text <span class="req">*</span></label>
                                <textarea class="form-control" id="cards___INDEX___text" name="cards[__INDEX__][text]" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="form-actions">
                    <x-admin.btn type="button" variant="secondary" icon="plus" data-add-card>Add card</x-admin.btn>
                    <span class="muted">Up to six cards.</span>
                </div>
            </x-admin.card>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">Save about page</x-admin.btn>
                <x-admin.btn href="{{ route('about') }}" variant="ghost" icon="external">Preview</x-admin.btn>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            (function () {
                const wrap = document.querySelector('[data-cards]');
                const template = document.querySelector('[data-card-template]');
                const add = document.querySelector('[data-add-card]');
                if (!wrap || !template || !add) return;

                let nextIndex = 1000;

                add.addEventListener('click', function () {
                    if (wrap.querySelectorAll('[data-card-slot]').length >= 6) {
                        window.adminToast && window.adminToast('error', 'Card limit reached', 'You can have up to six highlight cards.');
                        return;
                    }
                    const html = template.innerHTML.replaceAll('__INDEX__', String(nextIndex++));
                    wrap.insertAdjacentHTML('beforeend', html);
                });

                wrap.addEventListener('click', function (event) {
                    const remove = event.target.closest('[data-remove-card]');
                    if (!remove) return;
                    if (wrap.querySelectorAll('[data-card-slot]').length <= 1) {
                        window.adminToast && window.adminToast('error', 'Keep one card', 'The about page needs at least one highlight card.');
                        return;
                    }
                    remove.closest('[data-card-slot]').remove();
                });
            })();
        </script>
    @endpush
@endsection
