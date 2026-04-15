<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function GetDashboard()
    {
        $totalUsers = User::query()->count();
        $totalAdmins = Admin::query()->count();
        $activeAdmins = Admin::query()->where('isActive', true)->count();

        $today = Carbon::today();
        $attendanceUsersToday = Attendance::query()
            ->whereDate('created_at', $today)
            ->distinct('user_id')
            ->count('user_id');

        $attendanceRateToday = $totalUsers > 0
            ? (int) round(($attendanceUsersToday / $totalUsers) * 100)
            : 0;

        $newUsersThisMonth = User::query()
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        $recentUsers = User::query()
            ->latest('created_at')
            ->take(8)
            ->get(['id', 'name', 'email', 'created_at']);

        return view('auth.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'activeAdmins',
            'attendanceUsersToday',
            'attendanceRateToday',
            'newUsersThisMonth',
            'recentUsers',
        ));
    }

    public function ChartRegistrations(Request $request): JsonResponse
    {
        $days = (int) ($request->integer('days') ?? 30);
        $days = max(7, min(365, $days));

        $start = Carbon::today()->subDays($days - 1);

        $rows = User::query()
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->where('created_at', '>=', $start->copy()->startOfDay())
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        $map = $rows->pluck('c', 'd')->all();

        $labels = [];
        $values = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i)->toDateString();
            $labels[] = $d;
            $values[] = (int) ($map[$d] ?? 0);
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    public function ChartAttendance(Request $request): JsonResponse
    {
        $days = (int) ($request->integer('days') ?? 14);
        $days = max(7, min(365, $days));

        $start = Carbon::today()->subDays($days - 1);

        $rows = Attendance::query()
            ->selectRaw('DATE(created_at) as d, COUNT(DISTINCT user_id) as c')
            ->where('created_at', '>=', $start->copy()->startOfDay())
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        $map = $rows->pluck('c', 'd')->all();

        $labels = [];
        $values = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i)->toDateString();
            $labels[] = $d;
            $values[] = (int) ($map[$d] ?? 0);
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    public function ChartAttendanceStatusToday(): JsonResponse
    {
        $today = Carbon::today();

        $rows = DB::table('attendances')
            ->join('statuses', 'attendances.status_id', '=', 'statuses.id')
            ->select('statuses.type', DB::raw('COUNT(*) as c'))
            ->whereDate('attendances.created_at', $today)
            ->groupBy('statuses.type')
            ->orderBy('statuses.type')
            ->get();

        return response()->json([
            'labels' => $rows->pluck('type')->values(),
            'values' => $rows->pluck('c')->map(fn ($v) => (int) $v)->values(),
        ]);
    }
    public function IsAuth(Request $request)
    {
        $credentials = $request->only('admin_email', 'admin_password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'admin_email' => 'Invalid credentials',
        ]);
    }
    public function Logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
