<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('sort_order')->paginate(15);
        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'full_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:10240',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = ImageHelper::convertToWebp($request->file('logo'), 'partners', 80, 400);
        }

        Partner::create($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'full_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:10240',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = ImageHelper::convertToWebp($request->file('logo'), 'partners', 80, 400);
        }

        $partner->update($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Mitra dipindahkan ke tempat sampah.');
    }

    public function trash()
    {
        $partners = Partner::onlyTrashed()->latest('deleted_at')->paginate(15);
        return view('admin.partners.trash', compact('partners'));
    }

    public function restore(int $id)
    {
        Partner::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.partners.trash')->with('success', 'Mitra berhasil dipulihkan.');
    }

    public function forceDelete(int $id)
    {
        Partner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.partners.trash')->with('success', 'Mitra dihapus permanen.');
    }
}
