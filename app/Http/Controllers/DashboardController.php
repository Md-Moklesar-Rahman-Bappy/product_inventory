<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\AssetModel;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Maintenance;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard.
     */
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(10);

        $entityCounts = [
            'Categories'  => Category::count(),
            'Brands'      => Brand::count(),
            'Models'      => AssetModel::count(),
            'Products'    => Product::count(),
            'Maintenance' => Maintenance::count(),
            'Warranty'    => Product::whereNotNull('warranty_end')->count(),
        ];

        $now = Carbon::now();
        $soon = $now->copy()->addDays(30);

        $warrantyBreakdown = [
            'Active'        => Product::where('warranty_end', '>', $soon)->count(),
            'Expiring Soon' => Product::whereBetween('warranty_end', [$now, $soon])->count(),
            'Expired'       => Product::where('warranty_end', '<', $now)->count(),
        ];

        return view('dashboard', compact('logs', 'entityCounts', 'warrantyBreakdown'));
    }
}
