<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->get();
        return view('backend.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('backend.sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/sliders'), $filename);
            $data['image'] = 'uploads/sliders/' . $filename;
        }

        Slider::create($data);

        return redirect()->route('backend.sliders.index')->with('success', 'Thêm Slider thành công.');
    }

    public function edit(Slider $slider)
    {
        return view('backend.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image && file_exists(public_path($slider->image))) {
                @unlink(public_path($slider->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/sliders'), $filename);
            $data['image'] = 'uploads/sliders/' . $filename;
        }

        $slider->update($data);

        return redirect()->route('backend.sliders.index')->with('success', 'Cập nhật Slider thành công.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image && file_exists(public_path($slider->image))) {
            @unlink(public_path($slider->image));
        }
        $slider->delete();

        return redirect()->route('backend.sliders.index')->with('success', 'Xóa Slider thành công.');
    }
}
