<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Donation;
use App\Models\Partner;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->get();
        $services = Service::orderBy('sort_order')->get();
        $testimonials = Testimonial::approved()->where('visibility', 'public')->orWhere(function ($q) {
            $q->approved()->where('visibility', 'anonymous');
        })->latest()->take(8)->get();

        $donations = Donation::with('testimonial')
            ->where('status', 'confirmed')
            ->latest('confirmed_at')
            ->paginate(8);

        $totalDonations = Donation::where('status', 'confirmed')
            ->selectRaw('
                SUM(
                    CASE 
                        WHEN package = "level_01" THEN 500000
                        WHEN package = "level_02" THEN 5000000
                        WHEN package = "level_03" THEN 10000000
                        WHEN package = "custom" THEN COALESCE(custom_amount, 0)
                        ELSE 0 
                    END
                ) as total
            ')
            ->value('total');

        $partners = Partner::orderBy('sort_order')->get();

        $visitorTotal  = VisitorLog::count();
        $visitorToday  = VisitorLog::whereDate('visited_at', today())->count();
        $visitorMonth  = VisitorLog::whereMonth('visited_at', now()->month)
                            ->whereYear('visited_at', now()->year)->count();

        return view('public.home', compact(
            'sliders', 'services', 'testimonials', 'donations', 'totalDonations', 'partners',
            'visitorTotal', 'visitorToday', 'visitorMonth'
        ));
    }

    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'required|string|max:20',
            'donor_email' => 'nullable|email|max:255',
            'donation_program' => 'required|in:level_01,level_02,level_03,custom',
            'custom_value' => 'nullable|numeric|min:1000',
            'commitment_type' => 'required|in:pledge,paid',
            'payment_method' => 'required|in:transfer,cash',
            'transfer_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:10240',
            'donor_notes' => 'required|string|max:1000',
            'testimonial_visibility' => 'required|in:public,anonymous',
        ], [
            'donor_name.required' => 'Nama lengkap wajib diisi.',
            'donor_phone.required' => 'Nomor telepon wajib diisi.',
            'donation_program.required' => 'Pilih paket kemitraan.',
            'commitment_type.required' => 'Pilih status komitmen.',
            'payment_method.required' => 'Pilih metode pembayaran.',
            'donor_notes.required' => 'Testimoni wajib diisi.',
            'testimonial_visibility.required' => 'Pilih pengaturan publikasi.',
        ]);

        $proofPath = null;
        if ($request->hasFile('transfer_proof')) {
            $proofPath = ImageHelper::convertToWebp($request->file('transfer_proof'), 'donations', 80, 1200);
        }

        $donation = Donation::create([
            'donor_name' => $validated['donor_name'],
            'donor_phone' => $validated['donor_phone'],
            'donor_email' => $validated['donor_email'] ?? null,
            'package' => $validated['donation_program'],
            'custom_amount' => $validated['custom_value'] ?? null,
            'commitment_type' => $validated['commitment_type'],
            'payment_method' => $validated['payment_method'],
            'transfer_proof' => $proofPath,
            'status' => 'pending',
            'notes' => $validated['donor_notes'],
        ]);

        Testimonial::create([
            'donation_id' => $donation->id,
            'name' => $validated['donor_name'],
            'content' => $validated['donor_notes'],
            'visibility' => $validated['testimonial_visibility'],
            'is_approved' => false,
        ]);

        return back()->with('success', 'Terima kasih! Komitmen kemitraan Anda telah berhasil dikirim. Tim kami akan segera memverifikasi.');
    }
}
