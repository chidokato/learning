<?php



namespace App\Http\Controllers;

use App\Models\HomepageCategory;
use Illuminate\Http\Request;

class HomepageCategoryController extends Controller
{
    public function index()
    {
        $categories = HomepageCategory::orderBy('sort_order')->get();
        return view('backend.homepage_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.homepage_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'uploads/categories/' . $filename;
        }

        // We can keep svg_icon as null
        $data['svg_icon'] = null;

        HomepageCategory::create($data);

        return redirect()->route('backend.homepage_categories.index')->with('success', 'ThÃªm danh má»¥c thÃ nh cÃ´ng.');
    }

    public function edit(HomepageCategory $homepageCategory)
    {
        return view('backend.homepage_categories.edit', compact('homepageCategory'));
    }

    public function update(Request $request, HomepageCategory $homepageCategory)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($homepageCategory->image && file_exists(public_path($homepageCategory->image))) {
                @unlink(public_path($homepageCategory->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $data['image'] = 'uploads/categories/' . $filename;
        }

        $homepageCategory->update($data);

        return redirect()->route('backend.homepage_categories.index')->with('success', 'Cáº­p nháº­t danh má»¥c thÃ nh cÃ´ng.');
    }

    public function destroy(HomepageCategory $homepageCategory)
    {
        if ($homepageCategory->image && file_exists(public_path($homepageCategory->image))) {
            @unlink(public_path($homepageCategory->image));
        }
        $homepageCategory->delete();
        return redirect()->route('backend.homepage_categories.index')->with('success', 'XÃ³a danh má»¥c thÃ nh cÃ´ng.');
    }
}