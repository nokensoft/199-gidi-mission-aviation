<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_donations' => Donation::count(),
            'pending_donations' => Donation::where('status', 'pending')->count(),
            'confirmed_donations' => Donation::where('status', 'confirmed')->count(),
            'total_amount' => Donation::where('status', 'confirmed')->get()->sum('amount'),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('is_published', true)->count(),
            'total_testimonials' => Testimonial::count(),
            'approved_testimonials' => Testimonial::where('is_approved', true)->count(),
        ];

        $visitorStats = $this->getVisitorStats();

        return view('admin.dashboard', compact('stats', 'visitorStats'));
    }

    public function visitorData(Request $request)
    {
        $period = $request->get('period', 'daily');
        $data = $this->getVisitorChartData($period);

        return response()->json($data);
    }

    private function getVisitorStats(): array
    {
        return [
            'today' => VisitorLog::whereDate('visited_at', today())->count(),
            'week' => VisitorLog::where('visited_at', '>=', now()->startOfWeek())->count(),
            'month' => VisitorLog::where('visited_at', '>=', now()->startOfMonth())->count(),
            'year' => VisitorLog::where('visited_at', '>=', now()->startOfYear())->count(),
            'total' => VisitorLog::count(),
        ];
    }

    private function getVisitorChartData(string $period): array
    {
        $labels = [];
        $values = [];

        switch ($period) {
            case 'daily':
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $labels[] = $date->translatedFormat('D, d M');
                    $values[] = VisitorLog::whereDate('visited_at', $date)->count();
                }
                break;
            case 'weekly':
                for ($i = 7; $i >= 0; $i--) {
                    $start = now()->subWeeks($i)->startOfWeek();
                    $end = now()->subWeeks($i)->endOfWeek();
                    $labels[] = $start->format('d/m') . ' - ' . $end->format('d/m');
                    $values[] = VisitorLog::whereBetween('visited_at', [$start, $end])->count();
                }
                break;
            case 'monthly':
                for ($i = 11; $i >= 0; $i--) {
                    $date = now()->subMonths($i);
                    $labels[] = $date->translatedFormat('M Y');
                    $values[] = VisitorLog::whereMonth('visited_at', $date->month)
                        ->whereYear('visited_at', $date->year)->count();
                }
                break;
            case 'yearly':
                for ($i = 4; $i >= 0; $i--) {
                    $year = now()->subYears($i)->year;
                    $labels[] = (string) $year;
                    $values[] = VisitorLog::whereYear('visited_at', $year)->count();
                }
                break;
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
