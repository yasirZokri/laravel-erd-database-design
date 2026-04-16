<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\Status;
use App\Models\User;
use Dom\Attr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    //? here is add new Attendance
    public function AddAttendance(AttendanceRequest $request)
    {
        foreach ($request->attendance as $userId => $statusId) {
            Attendance::create([
                'user_id' => $userId,
                'status_id' => $statusId,
                'details' => $request->details[$userId] ?? null,
            ]);
        }

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'attendance.saved',
            'description' => 'Saved attendance for ' . count($request->attendance) . ' users.',
        ]);

        return redirect()->route('dashboard')->with('success', 'Attendance saved successfully 🌱');
    }


    public function UpdateAttendance(Request $request, $id)
    {
        $attendance = Attendance::find($id);

        if($attendance)
        {
            $attendance->update([
                'user_id' => $request->user_id,
                'status_id' => $request->status_id
            ]);

            return redirect()->route('dashboard');
        }
    }



    public function GetAttendance()
    {
        $users = User::select('name', 'id')->get();
        $statuses = Status::all();
        return view('auth.attendance', compact('users', 'statuses'));
    }


}
