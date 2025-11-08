<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\AppointmentDetail;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $services = \App\Models\Service::all();
        return view('home', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'integer|exists:services,service_id',
            'full_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // 🟢 1. Lấy hoặc tạo User (role_id = 4 nếu khách vãng lai)
            $userId = Auth::check()
                ? Auth::id()
                : $this->createGuestUser($request);

            // 🟢 2. Tạo hoặc lấy Customer tương ứng (nếu chưa có)
            $customer = \App\Models\Customer::firstOrCreate(
                ['user_id' => $userId],
                ['loyalty_points' => 0, 'total_spent' => 0]
            );

            // 🟢 3. Tạo Appointment
            $appointment = Appointment::create([
                'customer_id' => $customer->customer_id,
                'appointment_date' => $validated['booking_date'],
                'note' => $validated['note'] ?? null,
                'status' => 'pending',
            ]);

            // 🟢 4. Tạo các AppointmentDetail
            foreach ($validated['service_ids'] as $serviceId) {
                $service = Service::find($serviceId);
                \App\Models\AppointmentDetail::create([
                    'appointment_id' => $appointment->appointment_id,
                    'service_id' => $serviceId,
                    'quantity' => 1,
                    'unit_price' => $service->price ?? 0,
                ]);
            }

            DB::commit();
            return back()->with('success', '💖 Đặt lịch thành công! Nhân viên sẽ liên hệ xác nhận sớm.');

        } catch (\Throwable $ex) {
            DB::rollBack();
            report($ex);
            return back()->with('error', '⚠️ Có lỗi xảy ra khi đặt lịch. Vui lòng thử lại sau.');
        }
    }


    private function createGuestUser(Request $request)
    {
        // Nếu khách đã từng đặt bằng email/số điện thoại thì tái sử dụng
        $existingUser = User::where(function ($q) use ($request) {
            $q->where('email', $request->email)
                ->orWhere('phone_number', $request->phone_number);
        })->first();

        if ($existingUser) {
            return $existingUser->user_id;
        }

        // Nếu chưa có thì tạo user mới role_id = 4 (khách vãng lai)
        $guest = User::create([
            'full_name' => $request->full_name ?? 'Khách vãng lai',
            'phone_number' => $request->phone_number,
            'email' => $request->email ?? 'guest_' . now()->timestamp . '@guest.local',
            'password_hash' => bcrypt('guest_' . now()->timestamp),
            'role_id' => 4, //  Khách vãng lai
            'status' => 1,
            'created_at' => now(),
        ]);

        return $guest->user_id;
    }
}
