<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->paginate(15);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:10240',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = ImageHelper::convertToWebp($request->file('image'), 'sliders', 85, 1920);
        }

        $validated['is_active'] = $request->boolean('is_active');
        Slider::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:10240',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = ImageHelper::convertToWebp($request->file('image'), 'sliders', 85, 1920);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider dipindahkan ke tempat sampah.');
    }

    public function trash()
    {
        $sliders = Slider::onlyTrashed()->latest('deleted_at')->paginate(15);
        return view('admin.sliders.trash', compact('sliders'));
    }

    public function restore(int $id)
    {
        Slider::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.sliders.trash')->with('success', 'Slider berhasil dipulihkan.');
    }

    public function forceDelete(int $id)
    {
        Slider::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.sliders.trash')->with('success', 'Slider dihapus permanen.');
    }
}
