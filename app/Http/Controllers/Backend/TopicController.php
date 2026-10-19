<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $query = \App\Models\Topic::query();
        if ($type && in_array($type, ['course', 'test'])) {
            $query->where('type', $type);
        }
        $topics = $query->orderBy('name')->paginate(20)->withQueryString();
        $counts = [
            'all' => \App\Models\Topic::count(),
            'course' => \App\Models\Topic::where('type', 'course')->count(),
            'test' => \App\Models\Topic::where('type', 'test')->count(),
        ];
        return view('backend.topics.index', compact('topics', 'type', 'counts'));
    }

    public function create()
    {
        $types = \App\Models\Topic::types();
        return view('backend.topics.create', compact('types'));
    }

    public function store(Request $request)
    {
        $type = $request->input('type', 'course');
        $validated = $request->validate([
            'type' => ['required', 'in:course,test'],
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('topics', 'name')->where('type', $type),
            ],
            'slug' => ['nullable', 'string', 'max:255'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ]);

        $slugInput = $request->input('slug');
        $slug = ! empty($slugInput) ? \Illuminate\Support\Str::slug($slugInput) : \Illuminate\Support\Str::slug($validated['name']);

        \App\Models\Topic::create([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'slug' => $slug,
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
        ]);

        return redirect()->route('backend.topics.index', ['type' => $validated['type']])->with('success', 'Thêm Chủ đề thành công.');
    }

    public function edit(\App\Models\Topic $topic)
    {
        $types = \App\Models\Topic::types();
        return view('backend.topics.edit', compact('topic', 'types'));
    }

    public function update(Request $request, \App\Models\Topic $topic)
    {
        $type = $request->input('type', $topic->type ?? 'course');
        $validated = $request->validate([
            'type' => ['required', 'in:course,test'],
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('topics', 'name')->where('type', $type)->ignore($topic->id),
            ],
            'slug' => ['nullable', 'string', 'max:255'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ]);

        $slugInput = $request->input('slug');
        $slug = ! empty($slugInput) ? \Illuminate\Support\Str::slug($slugInput) : \Illuminate\Support\Str::slug($validated['name']);

        $topic->update([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'slug' => $slug,
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
        ]);

        return redirect()->route('backend.topics.index', ['type' => $validated['type']])->with('success', 'Cập nhật Chủ đề thành công.');
    }

    public function destroy(\App\Models\Topic $topic)
    {
        $type = $topic->type;
        $topic->delete();
        return redirect()->route('backend.topics.index', ['type' => $type])->with('success', 'Xóa Chủ đề thành công.');
    }

    public function quickAdd(Request $request)
    {
        $type = $request->input('type', 'course');
        if (!in_array($type, ['course', 'test'])) {
            $type = 'course';
        }

        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('topics', 'name')->where('type', $type),
            ],
            'type' => ['nullable', 'in:course,test'],
        ]);

        $topic = \App\Models\Topic::create([
            'type' => $type,
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
        ]);

        return response()->json([
            'success' => true,
            'topic' => [
                'id' => $topic->id,
                'type' => $topic->type,
                'name' => $topic->name,
            ]
        ]);
    }
}
