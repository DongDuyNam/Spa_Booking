<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffSchedule;
use App\Models\User;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index($id)
    {
        $staff = User::findOrFail($id);
        $schedules = StaffSchedule::where('staff_id', $id)
            ->orderBy('work_date', 'asc')
            ->get();

        return view('admin.staff.schedule', compact('staff', 'schedules'));
    }

    public function create($id)
    {
        $staff = User::findOrFail($id);
        return view('admin.staff.schedule_create', compact('staff'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'work_date' => 'required|date',
            'shift' => 'required|string|max:50',
        ]);

        StaffSchedule::create([
            'staff_id' => $id,
            'branch_id' => auth()->user()->branch_id ?? 1,
            'work_date' => Carbon::parse($request->work_date),
            'shift' => $request->shift,
        ]);

        return redirect()->route('admin.schedule.index', $id)
                         ->with('success', 'Đã thêm lịch làm việc.');
    }

    public function destroy($schedule_id)
    {
        StaffSchedule::findOrFail($schedule_id)->delete();
        return back()->with('success', 'Đã xóa lịch làm việc.');
    }
}
