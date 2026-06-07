<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with('testimonial')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('donor_name', 'like', "%{$request->search}%")
                  ->orWhere('donor_phone', 'like', "%{$request->search}%");
            });
        }

        $donations = $query->paginate(15);

        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        return view('admin.donations.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'required|string|max:50',
            'package' => 'required|in:level_01,level_02,level_03,custom',
            'custom_amount' => 'nullable|numeric|min:0',
            'commitment_type' => 'required|in:pledge,paid',
            'payment_method' => 'required|in:transfer,cash',
            'status' => 'required|in:pending,confirmed,rejected',
            'notes' => 'nullable|string',
            'transfer_proof' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('transfer_proof')) {
            $validated['transfer_proof'] = ImageHelper::convertToWebp($request->file('transfer_proof'), 'donations', 80, 1200);
        }

        if ($validated['status'] === 'confirmed') {
            $validated['confirmed_by'] = auth()->id();
            $validated['confirmed_at'] = now();
        }

        Donation::create($validated);

        return redirect()->route('admin.donations.index')->with('success', 'Donasi berhasil ditambahkan.');
    }

    public function show(Donation $donation)
    {
        $donation->load(['testimonial', 'confirmedByUser']);
        return view('admin.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        return view('admin.donations.form', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'required|string|max:50',
            'package' => 'required|in:level_01,level_02,level_03,custom',
            'custom_amount' => 'nullable|numeric|min:0',
            'commitment_type' => 'required|in:pledge,paid',
            'payment_method' => 'required|in:transfer,cash',
            'status' => 'required|in:pending,confirmed,rejected',
            'notes' => 'nullable|string',
            'transfer_proof' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('transfer_proof')) {
            $validated['transfer_proof'] = ImageHelper::convertToWebp($request->file('transfer_proof'), 'donations', 80, 1200);
        }

        if ($validated['status'] === 'confirmed' && $donation->status !== 'confirmed') {
            $validated['confirmed_by'] = auth()->id();
            $validated['confirmed_at'] = now();
        }

        $donation->update($validated);

        return redirect()->route('admin.donations.index')->with('success', 'Donasi berhasil diperbarui.');
    }

    public function confirm(Donation $donation)
    {
        $donation->update([
            'status' => 'confirmed',
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
        ]);

        if ($donation->testimonial) {
            $donation->testimonial->update(['is_approved' => true]);
        }

        return back()->with('success', 'Donasi berhasil dikonfirmasi.');
    }

    public function reject(Donation $donation)
    {
        $donation->update([
            'status' => 'rejected',
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Donasi telah ditolak.');
    }

    public function uploadProof(Request $request, Donation $donation)
    {
        $request->validate([
            'admin_proof' => 'required|file|mimes:jpg,jpeg,png,pdf,webp|max:10240',
        ]);

        $path = ImageHelper::convertToWebp($request->file('admin_proof'), 'donations', 80, 1200);
        $donation->update(['admin_proof' => $path]);

        return back()->with('success', 'Bukti transfer berhasil diupload.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Donasi dipindahkan ke tempat sampah.');
    }

    public function trash()
    {
        $donations = Donation::onlyTrashed()->latest('deleted_at')->paginate(15);
        return view('admin.donations.trash', compact('donations'));
    }

    public function restore(int $id)
    {
        Donation::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.donations.trash')->with('success', 'Donasi berhasil dipulihkan.');
    }

    public function forceDelete(int $id)
    {
        Donation::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.donations.trash')->with('success', 'Donasi dihapus permanen.');
    }
}
