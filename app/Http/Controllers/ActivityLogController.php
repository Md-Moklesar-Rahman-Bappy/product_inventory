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
            'user_id' => $user?->id,
            'action' => $action,
            'model' => $model,
            'model_id' => $model_id ?? null,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'role' => $user?->role ?? 'guest',
        ]);
    }

    /**
     * Display a paginated list of activity logs with optional filtering.
     */
    public function index(Request $request)
    {
        $modelFilter = $request->query('model');

        $logsQuery = ActivityLog::with('user')
            ->when($modelFilter, function ($q) use ($modelFilter) {
                // Check if filtering by action (like 'login', 'create', etc.)
                $actions = ['login', 'logout', 'create', 'update', 'delete', 'restore', 'status-toggle', 'send-credentials', 'verification-init'];
                if (in_array($modelFilter, $actions)) {
                    return $q->where('action', $modelFilter);
                }

                // Otherwise filter by model type
                return $q->where('model', $modelFilter);
            })
            ->latest();

        $logs = $logsQuery->paginate(15);

        return view('activity_logs.index', [
            'logs' => $logs,
            'modelFilter' => $modelFilter,
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
