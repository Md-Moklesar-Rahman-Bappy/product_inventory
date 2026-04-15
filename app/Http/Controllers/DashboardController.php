<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\AssetModel;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Maintenance;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard.
     */
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(10);

        $entityCounts = [
            'Categories' => Category::count(),
            'Brands' => Brand::count(),
            'Models' => AssetModel::count(),
            'Products' => Product::count(),
            'Maintenance' => Maintenance::count(),
            'Warranty' => Product::whereNotNull('warranty_end')->count(),
        ];

        $now = Carbon::now();
        $soon = $now->copy()->addDays(30);

        $warrantyBreakdown = [
            'Active' => Product::where('warranty_end', '>', $soon)->count(),
            'Expiring Soon' => Product::whereBetween('warranty_end', [$now, $soon])->count(),
            'Expired' => Product::where('warranty_end', '<', $now)->count(),
        ];

        $recentProducts = Product::latest()->take(5)->get();
        $expiringWarranties = Product::whereBetween('warranty_end', [$now, $soon])->take(5)->get();
        $pendingMaintenance = Maintenance::where('end_time', '>', $now)->where('start_time', '<=', $now)->take(5)->get();

        $productTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $productTrend[] = [
                'month' => $month->format('M'),
                'count' => Product::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->count(),
            ];
        }

        return view('dashboard', compact(
            'logs',
            'entityCounts',
            'warrantyBreakdown',
            'recentProducts',
            'expiringWarranties',
            'pendingMaintenance',
            'productTrend'
        ));
    }
}
