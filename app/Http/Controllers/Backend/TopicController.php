<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = \App\Models\Topic::orderBy('name')->paginate(20);
        return view('backend.topics.index', compact('topics'));
    }

    public function create()
    {
        return view('backend.topics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topics,name'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:topics,slug'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ]);

        $slugInput = $request->input('slug');
        $slug = ! empty($slugInput) ? \Illuminate\Support\Str::slug($slugInput) : \Illuminate\Support\Str::slug($validated['name']);

        \App\Models\Topic::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
        ]);

        return redirect()->route('backend.topics.index')->with('success', 'Thêm Chủ đề thành công.');
    }

    public function edit(\App\Models\Topic $topic)
    {
        return view('backend.topics.edit', compact('topic'));
    }

    public function update(Request $request, \App\Models\Topic $topic)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('topics', 'name')->ignore($topic->id)],
            'slug' => ['nullable', 'string', 'max:255', \Illuminate\Validation\Rule::unique('topics', 'slug')->ignore($topic->id)],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ]);

        $slugInput = $request->input('slug');
        $slug = ! empty($slugInput) ? \Illuminate\Support\Str::slug($slugInput) : \Illuminate\Support\Str::slug($validated['name']);

        $topic->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
        ]);

        return redirect()->route('backend.topics.index')->with('success', 'Cập nhật Chủ đề thành công.');
    }

    public function destroy(\App\Models\Topic $topic)
    {
        $topic->delete();
        return redirect()->route('backend.topics.index')->with('success', 'Xóa Chủ đề thành công.');
    }

    public function quickAdd(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topics,name'],
        ]);

        $topic = \App\Models\Topic::create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
        ]);

        return response()->json([
            'success' => true,
            'topic' => [
                'id' => $topic->id,
                'name' => $topic->name,
            ]
        ]);
    }
}
