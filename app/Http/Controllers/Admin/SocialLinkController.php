<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function store(Request $request)
    {
        $data = $this->validated($request);

        SocialLink::create($data);

        return back()->with('success', 'Social link added.');
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $socialLink->update($this->validated($request, $socialLink));

        return back()->with('success', 'Social link updated.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return back()->with('success', 'Social link removed.');
    }

    private function validated(Request $request, ?SocialLink $socialLink = null): array
    {
        $data = $request->validate([
            'platform' => ['required', 'string', 'max:60'],
            'url' => ['required', 'string', 'max:300'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'published' => ['sometimes', 'boolean'],
        ]);

        $data['published'] = ! empty($data['published']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
