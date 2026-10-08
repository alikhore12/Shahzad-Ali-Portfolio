<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    private const DEFAULTS = [
        'about_title' => 'A developer who cares about the details.',
        'about_intro' => 'I’m Shahzad Ali, a BS Computer Science student building a practical foundation in full-stack development, design and digital growth.',
        'about_cards' => [
            ['label' => '01', 'title' => 'My approach', 'text' => 'Start with the real problem, make the structure clear, then sweat the details that help people move with confidence.'],
            ['label' => '02', 'title' => 'My strengths', 'text' => 'Curiosity, patience and the ability to connect product thinking with implementation.'],
            ['label' => '03', 'title' => 'What’s next', 'text' => 'Growing through purposeful projects, collaboration and a steady commitment to better craft.'],
        ],
    ];

    public function edit()
    {
        return view('admin.about.edit', [
            'title' => Setting::value('about_title', self::DEFAULTS['about_title']),
            'intro' => Setting::value('about_intro', self::DEFAULTS['about_intro']),
            'cards' => old('cards') ?: $this->cards(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'about_title' => ['required', 'string', 'max:180'],
            'about_intro' => ['required', 'string', 'max:500'],
            'cards' => ['required', 'array', 'min:1', 'max:6'],
            'cards.*.label' => ['required', 'string', 'max:20'],
            'cards.*.title' => ['required', 'string', 'max:120'],
            'cards.*.text' => ['required', 'string', 'max:600'],
        ]);

        Setting::many([
            'about_title' => $data['about_title'],
            'about_intro' => $data['about_intro'],
            'about_cards' => json_encode(array_values($data['cards'])),
        ]);

        return redirect()->route('admin.about.edit')->with('success', 'About page updated successfully.');
    }

    public static function defaults(): array
    {
        return self::DEFAULTS;
    }

    private function cards(): array
    {
        $stored = Setting::value('about_cards');

        if (! $stored) {
            return self::DEFAULTS['about_cards'];
        }

        $decoded = json_decode($stored, true);

        return is_array($decoded) ? $decoded : self::DEFAULTS['about_cards'];
    }
}
