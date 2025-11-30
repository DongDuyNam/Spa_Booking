<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with([
            'customer',
            'staff.user',
            'details.service'
        ])->orderByDesc('appointment_id');

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        $appointments = $query->paginate(10)->appends($request->query());
        $staffs = Staff::with('user')->get();

        return view('admin.appointments.index', compact('appointments', 'staffs'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'nullable',
            'duration_minutes' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'staff_id' => 'nullable|exists:staff,staff_id',
            'note' => 'nullable|string',
        ]);

        if (!empty($data['appointment_time']) && strlen($data['appointment_time']) === 5) {
            $data['appointment_time'] .= ':00';
        }

        if ($data['status'] === 'pending') {
            $data['staff_id'] = null;
        }

        $appointment->update($data);

        return back()->with('success', 'Cập nhật lịch hẹn thành công');
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->status = 'cancelled';
        $appointment->staff_id = null;
        $appointment->save();

        return back()->with('success', 'Đã huỷ lịch hẹn');
    }

    public function assign(Request $request, Appointment $appointment)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,staff_id'
        ]);

        $staffId = $request->staff_id;

        $startAt = Carbon::parse(
            $appointment->appointment_date . ' ' . $appointment->appointment_time
        );

        $endAt = (clone $startAt)->addMinutes($appointment->duration_minutes);

        $conflict = Appointment::where('staff_id', $staffId)
            ->where('status', '!=', 'cancelled')
            ->where('appointment_id', '!=', $appointment->appointment_id)
            ->where(function ($q) use ($startAt, $endAt) {
                $q->whereRaw("
                    STR_TO_DATE(CONCAT(appointment_date, ' ', appointment_time), '%Y-%m-%d %H:%i:%s')
                    < ?
                ", [$endAt])
                    ->whereRaw("
                    DATE_ADD(
                        STR_TO_DATE(CONCAT(appointment_date, ' ', appointment_time), '%Y-%m-%d %H:%i:%s'),
                        INTERVAL duration_minutes MINUTE
                    ) > ?
                ", [$startAt]);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'staff_id' => 'Nhân viên đã có lịch trùng thời gian này'
            ]);
        }

        $appointment->staff_id = $staffId;

        if ($appointment->status === 'pending') {
            $appointment->status = 'confirmed';
        }

        $appointment->save();

        return back()->with('success', 'Phân công thành công');
    }

    public function getAvailableStaff(Appointment $appointment)
    {
        $startAt = Carbon::parse(
            $appointment->appointment_date . ' ' . $appointment->appointment_time
        );

        $endAt = (clone $startAt)->addMinutes($appointment->duration_minutes);

        $staffs = Staff::with('user')
            ->whereHas('schedules', function ($q) use ($startAt, $endAt, $appointment) {
                $q->whereDate('work_date', $appointment->appointment_date)
                    ->where('status', 'confirmed')
                    ->whereTime('start_time', '<=', $startAt->format('H:i:s'))
                    ->whereTime('end_time', '>=', $endAt->format('H:i:s'));
            })
            ->whereDoesntHave('appointments', function ($q) use ($startAt, $endAt, $appointment) {
                $q->where('status', '!=', 'cancelled')
                    ->where('appointment_id', '!=', $appointment->appointment_id)
                    ->whereRaw("
                    STR_TO_DATE(CONCAT(appointment_date, ' ', appointment_time), '%Y-%m-%d %H:%i:%s')
                    < ?
                ", [$endAt])
                    ->whereRaw("
                    DATE_ADD(
                        STR_TO_DATE(CONCAT(appointment_date, ' ', appointment_time), '%Y-%m-%d %H:%i:%s'),
                        INTERVAL duration_minutes MINUTE
                    ) > ?
                ", [$startAt]);
            })
            ->get();

        return response()->json($staffs);
    }

}
