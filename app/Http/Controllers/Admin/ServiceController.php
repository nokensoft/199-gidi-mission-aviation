<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
            'color' => 'required|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
            'color' => 'required|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Layanan dipindahkan ke tempat sampah.');
    }

    public function trash()
    {
        $services = Service::onlyTrashed()->latest('deleted_at')->paginate(15);
        return view('admin.services.trash', compact('services'));
    }

    public function restore(int $id)
    {
        Service::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.services.trash')->with('success', 'Layanan berhasil dipulihkan.');
    }

    public function forceDelete(int $id)
    {
        Service::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.services.trash')->with('success', 'Layanan dihapus permanen.');
    }
}
