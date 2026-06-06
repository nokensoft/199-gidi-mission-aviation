<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('donation')->latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_title' => 'nullable|string|max:255',
            'content' => 'required|string|max:1000',
            'visibility' => 'required|in:public,anonymous',
        ]);

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function toggleApproval(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => !$testimonial->is_approved]);

        $status = $testimonial->is_approved ? 'disetujui' : 'dibatalkan persetujuannya';
        return back()->with('success', "Testimoni berhasil {$status}.");
    }

    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);

        $status = $testimonial->is_featured ? 'ditampilkan unggulan' : 'dihapus dari unggulan';
        return back()->with('success', "Testimoni berhasil {$status}.");
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni dipindahkan ke tempat sampah.');
    }

    public function trash()
    {
        $testimonials = Testimonial::onlyTrashed()->latest('deleted_at')->paginate(15);
        return view('admin.testimonials.trash', compact('testimonials'));
    }

    public function restore(int $id)
    {
        Testimonial::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.testimonials.trash')->with('success', 'Testimoni berhasil dipulihkan.');
    }

    public function forceDelete(int $id)
    {
        Testimonial::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.testimonials.trash')->with('success', 'Testimoni dihapus permanen.');
    }
}
