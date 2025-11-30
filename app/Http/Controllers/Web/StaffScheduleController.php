<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StaffSchedule;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffSchedule::with(['staff.user'])->orderByDesc('schedule_id');

        if ($request->filled('work_date')) {
            $query->where('work_date', $request->work_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->paginate(10)->appends($request->query());
        $staffs = Staff::with('user')->get();

        return view('admin.schedules.index', compact('schedules', 'staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,staff_id',
            'work_date' => 'required|date',
            'shift' => 'required|in:Sáng,Chiều,Tối,Full time',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'notes' => 'nullable|string',
        ]);

        StaffSchedule::create([
            'staff_id' => $request->staff_id,
            'branch_id' => Staff::find($request->staff_id)->user->branch_id,
            'work_date' => $request->work_date,
            'shift' => $request->shift,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Thêm lịch làm thành công!');
    }

    public function update(Request $request, $id)
    {
        $schedule = StaffSchedule::findOrFail($id);

        $request->validate([
            'staff_id' => 'required|exists:staff,staff_id',
            'work_date' => 'required|date',
            'shift' => 'required|in:Sáng,Chiều,Tối,Full time',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:pending,confirmed,cancelled',
        ]);

        $staff = Staff::with('user')->findOrFail($request->staff_id);

        $schedule->update([
            'staff_id' => $staff->staff_id,
            'branch_id' => $staff->user->branch_id ?? null,
            'work_date' => $request->work_date,
            'shift' => $request->shift,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'notes' => $request->notes,
            'status' => $request->status ?? 'pending',
        ]);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Cập nhật lịch làm thành công!');
    }

    public function destroy($id)
    {
        $schedule = StaffSchedule::findOrFail($id);
        $schedule->delete();

        return back()->with('success', 'Đã xóa lịch làm!');
    }
}
