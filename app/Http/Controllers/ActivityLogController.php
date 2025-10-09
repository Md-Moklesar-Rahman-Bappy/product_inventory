<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Log an action to the activity log.
     */
    public static function logAction($action, $model, $model_id, $description)
    {
        $user = auth()->user();

        ActivityLog::create([
            'user_id'     => $user?->id,
            'action'      => $action,
            'model'       => $model,
            'model_id'    => $model_id ?? null,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->header('User-Agent'),
            'role'        => $user?->role ?? 'guest',
        ]);
    }

    /**
     * Display a paginated list of activity logs with optional model filtering.
     */
    public function index(Request $request)
    {
        $modelFilter = $request->query('model');

        $logsQuery = ActivityLog::with('user')
            ->when($modelFilter, fn($q) => $q->where('model', $modelFilter))
            ->latest();

        $logs = $logsQuery->paginate(10);

        // Group logs by extracted serial number from description
        $groupedLogs = $logs->getCollection()->groupBy(function ($log) {
            if (preg_match('/Serial No:\s*([A-Za-z0-9\-]+)/', $log->description, $matches)) {
                return $matches[1];
            }
            return 'No Serial';
        });

        return view('activity_logs.index', [
            'logs'         => $logs,
            'groupedLogs'  => $groupedLogs,
            'modelFilter'  => $modelFilter,
        ]);
    }

    /**
     * Display logs for a specific product.
     */
    public function productLogs($id)
    {
        $logs = ActivityLog::where('model', 'Product')
            ->where('model_id', $id)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('activity_logs.product', compact('logs'));
    }

    /**
     * Display logs for a specific user.
     */
    public function userLogs($id)
    {
        $logs = ActivityLog::where('user_id', $id)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('activity_logs.user', compact('logs'));
    }

    /**
     * Display logs for a specific model type.
     */
    public function modelLogs($model)
    {
        $logs = ActivityLog::where('model', $model)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('activity_logs.model', compact('logs', 'model'));
    }
}
