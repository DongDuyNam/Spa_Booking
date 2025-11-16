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

        // --- Lọc từ khóa ---
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->whereHas('staff.user', function ($q) use ($keyword) {
                $q->where('full_name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('phone_number', 'like', "%$keyword%");
            });
        }

        // --- Lọc ngày ---
        if ($request->filled('work_date')) {
            $query->where('work_date', $request->work_date);
        }

        // --- Lọc tuần ---
        if ($request->filled('week')) {
            [$year, $week] = explode('-W', $request->week);

            $query->whereRaw("YEAR(work_date) = ?", [$year])
                ->whereRaw("WEEK(work_date, 1) = ?", [$week]);
        }

        // --- Lọc tháng ---
        if ($request->filled('month')) {
            $query->whereRaw("DATE_FORMAT(work_date, '%Y-%m') = ?", [$request->month]);
        }

        // --- Lọc trạng thái ---
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // --- Lọc nhiều nhân viên ---
        if ($request->filled('staff_ids')) {
            $query->whereIn('staff_id', $request->staff_ids);
        }

        // --- Lọc nhiều ca ---
        if ($request->filled('shifts')) {
            $query->whereIn('shift', $request->shifts);
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
            'shift' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'notes' => 'nullable|string',
            'status' => 'required|string',
        ]);


        $staff = Staff::with('user')->findOrFail($request->staff_id);

        StaffSchedule::create([
            'staff_id' => $staff->staff_id,
            'branch_id' => $staff->user->branch_id ?? null,
            'work_date' => $request->work_date,
            'shift' => $request->shift,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Thêm lịch làm việc thành công!');
    }


    public function update(Request $request, $id)
    {
        $schedule = StaffSchedule::with('staff.user')->findOrFail($id);

        $request->validate([
            'staff_id' => 'required|exists:staff,staff_id',
            'work_date' => 'required|date',
            'shift' => 'required|string|max:50',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|string|in:pending,confirmed,cancelled,off',
            'notes' => 'nullable|string',
        ]);

        $staff = Staff::with('user')->findOrFail($request->staff_id);

        $schedule->update([
            'staff_id' => $staff->staff_id,
            'branch_id' => $staff->user->branch_id ?? null,
            'work_date' => $request->work_date,
            'shift' => $request->shift,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', "Cập nhật lịch làm #{$id} thành công!");
    }

    public function destroy($id)
    {
        $schedule = StaffSchedule::findOrFail($id);
        $schedule->delete();

        return back()->with('success', 'Đã xóa lịch làm!');
    }
}
