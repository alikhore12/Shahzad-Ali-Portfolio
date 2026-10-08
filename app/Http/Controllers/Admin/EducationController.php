<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        $educations = Education::orderBy('sort_order')->latest()->paginate(10);

        return view('admin.education.index', compact('educations'));
    }

    public function create()
    {
        return view('admin.education.create');
    }

    public function store(Request $request)
    {
        Education::create($this->validated($request));

        return redirect()->route('admin.education.index')->with('success', 'Education entry added successfully.');
    }

    public function edit(Education $education)
    {
        return view('admin.education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $education->update($this->validated($request));

        return redirect()->route('admin.education.index')->with('success', 'Education entry updated successfully.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->route('admin.education.index')->with('success', 'Education entry deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'institution' => ['required', 'string', 'max:150'],
            'degree' => ['required', 'string', 'max:150'],
            'period' => ['nullable', 'string', 'max:60'],
            'description' => ['required', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'published' => ['sometimes', 'boolean'],
        ]);

        $data['published'] = ! empty($data['published']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
