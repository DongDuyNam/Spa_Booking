<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\AppointmentDetail;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        return view('customer.dashboard');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function appointments(Request $request)
    {
        $customer = Auth::user()->customerData;

        if (!$customer) {
            return view('customer.appointments', ['appointments' => collect([])]);
        }

        $customerId = $customer->customer_id;


        $status = $request->status;
        $from = $request->from_date;
        $to = $request->to_date;

        $query = Appointment::with(['details.service', 'staff'])
            ->where('customer_id', $customerId);

        // Filter theo trạng thái
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Filter ngày bắt đầu
        if ($from) {
            $query->whereDate('appointment_date', '>=', $from);
        }

        // Filter ngày kết thúc
        if ($to) {
            $query->whereDate('appointment_date', '<=', $to);
        }

        // Sắp xếp trạng thái (pending trước)
        $query->orderByRaw("
            CASE status
                WHEN 'pending' THEN 1
                WHEN 'confirmed' THEN 2
                WHEN 'completed' THEN 3
                WHEN 'cancelled' THEN 4
                ELSE 5
            END
        ")
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time');

        $appointments = $query->paginate(10)->withQueryString();

        return view('customer.appointments', compact('appointments'));
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->update([
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
        ]);

        $customer = $user->customerData;

        if (!$customer) {
            $customer = Customer::create([
                'user_id' => $user->user_id,
                'loyalty_points' => 0,
                'total_spent' => 0,
            ]);
        }

        $customer->update([
            'birth_date' => $request->birth_date,
            'address' => $request->address,
        ]);

        return redirect()->route('customer.profile')->with('success', 'Cập nhật thành công!');
    }

    /* ------------------------ CANCEL ------------------------- */
    public function cancel($id)
    {
        $appointment = Appointment::where('appointment_id', $id)
            ->where('customer_id', Auth::user()->customerData->customer_id)
            ->firstOrFail();

        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Không thể hủy lịch này.');
        }

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Hủy lịch thành công!');
    }

    /* ------------------------ REBOOK ------------------------- */
    public function rebook(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|string',
        ]);

        $customerId = Auth::user()->customerData->customer_id;

        $old = Appointment::where('appointment_id', $id)
            ->where('customer_id', $customerId)
            ->with('details')
            ->firstOrFail();

        // ❗CHECK SLOT
        $exists = Appointment::where('appointment_date', $request->date)
            ->where('appointment_time', $request->time)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Giờ này đã có người đặt, vui lòng chọn giờ khác.');
        }

        $new = Appointment::create([
            'customer_id' => $old->customer_id,
            'staff_id' => null,
            'appointment_date' => $request->date,
            'appointment_time' => $request->time,
            'duration_minutes' => $old->duration_minutes,
            'status' => 'pending',
            'note' => $old->note,
        ]);

        foreach ($old->details as $d) {
            AppointmentDetail::create([
                'appointment_id' => $new->appointment_id,
                'service_id' => $d->service_id,
                'quantity' => $d->quantity,
                'unit_price' => $d->unit_price,
            ]);
        }

        return back()->with('success', 'Đặt lại lịch thành công!');
    }


    /* -------------------- API load dịch vụ -------------------- */
    public function apiGetAppointment($id)
    {
        $appointment = Appointment::with('details.service')
            ->where('appointment_id', $id)
            ->firstOrFail();

        return response()->json([
            'services' => $appointment->details->map(function ($detail) {
                return [
                    'service_id' => $detail->service_id,
                    'name' => $detail->service->name,
                ];
            }),
        ]);
    }
}
