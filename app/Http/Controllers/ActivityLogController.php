<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::query()
            ->with(['user:id,name,email', 'admin:admin_id,admin_email'])
            ->latest('created_at')
            ->take(200)
            ->get();

        return view('activity_logs.index', compact('logs'));
    }
}

