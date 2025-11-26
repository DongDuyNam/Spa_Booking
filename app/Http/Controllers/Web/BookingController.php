<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\Service;
use App\Models\ServicePackage;
use App\Models\Appointment;
use App\Models\AppointmentDetail;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function index()
    {
        // Dịch vụ đơn lẻ
        $services = Service::where('is_active', 1)
            ->orderByDesc('service_id')
            ->take(10)
            ->get();

        // Gói dịch vụ + danh sách service_id trong gói
        $packages = ServicePackage::where('is_active', 1)
            ->with('packageServices')
            ->orderByDesc('package_id')
            ->take(8)
            ->get();

        foreach ($packages as $p) {
            $p->serviceListString = $p->packageServices
                ->pluck('service_id')
                ->implode(',');
        }

        return view('home', compact('services', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|string',

            'booking_type' => 'required|in:single,package',

            'service_ids' => 'nullable|array',
            'service_ids.*' => 'integer|exists:services,service_id',

            'package_id' => 'nullable|integer|exists:service_packages,package_id',

            'full_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // USER / CUSTOMER
            $userId = Auth::check()
                ? Auth::id()
                : $this->createGuestUser($request);

            $customer = Customer::firstOrCreate(
                ['user_id' => $userId],
                ['loyalty_points' => 0, 'total_spent' => 0]
            );

            // Gom list service_id từ gói + dịch vụ đơn lẻ
            $serviceIds = [];

            if (!empty($validated['package_id'])) {
                $package = ServicePackage::with('packageServices')
                    ->findOrFail($validated['package_id']);

                $serviceIds = $package->packageServices
                    ->pluck('service_id')
                    ->toArray();
            }

            if (!empty($validated['service_ids'])) {
                $serviceIds = array_merge($serviceIds, $validated['service_ids']);
            }

            $serviceIds = array_values(array_unique($serviceIds));

            if (count($serviceIds) === 0) {
                return back()
                    ->with('error', '⚠️ Vui lòng chọn dịch vụ hoặc gói dịch vụ.')
                    ->withInput();
            }

            $services = Service::whereIn('service_id', $serviceIds)->get();

            if ($services->count() === 0) {
                return back()
                    ->with('error', '⚠️ Không tìm thấy dịch vụ hợp lệ.')
                    ->withInput();
            }

            if (!empty($validated['package_id'])) {

                // Nếu gói có duration riêng → dùng nó
                if ($package->duration_minutes && $package->duration_minutes > 0) {
                    $totalDuration = $package->duration_minutes;
                } else {
                    // Không có duration thì tính từ các dịch vụ trong gói
                    $totalDuration = (int) $services->sum('duration_minutes');
                }

            } else {
                // Đặt dịch vụ đơn
                $totalDuration = (int) $services->sum('duration_minutes');
            }

            if ($totalDuration <= 0) {
                $totalDuration = 60; // fallback
            }


            $bookingDate = Carbon::parse($validated['booking_date'])->format('Y-m-d');
            $chosenTime = $validated['booking_time']
                ?: $this->pickSlotForDate($bookingDate, $totalDuration);


            // Tạo appointment
            $appointment = Appointment::create([
                'customer_id' => $customer->customer_id,
                'appointment_date' => $bookingDate,
                'appointment_time' => $chosenTime,
                'duration_minutes' => $totalDuration,
                'note' => $validated['note'] ?? null,
                'status' => 'pending',
            ]);

            // Chi tiết dịch vụ
            foreach ($services as $service) {
                AppointmentDetail::create([
                    'appointment_id' => $appointment->appointment_id,
                    'service_id' => $service->service_id,
                    'quantity' => 1,
                    'unit_price' => $service->price ?? 0,
                ]);
            }

            DB::commit();

            return back()->with(
                'success',
                "💖 Đặt lịch thành công vào {$chosenTime} ngày " .
                Carbon::parse($bookingDate)->format('d/m/Y')
            );

        } catch (\Throwable $ex) {
            DB::rollBack();
            report($ex);

            return back()
                ->with('error', '⚠️ Lỗi hệ thống, vui lòng thử lại.')
                ->withInput();
        }
    }

    public function pickSlotForDate(string $date, int $duration)
    {
        $resp = Http::get(url('/slots'), [
            'date' => $date,
            'duration' => $duration,
        ]);

        return $resp->json()['slots'][0] ?? null;
    }


    private function createGuestUser(Request $request): int
    {
        $existingUser = User::where(function ($q) use ($request) {
            $q->when($request->email, fn($q2) => $q2->orWhere('email', $request->email))
                ->when($request->phone_number, fn($q2) => $q2->orWhere('phone_number', $request->phone_number));
        })->first();

        if ($existingUser) {
            return $existingUser->user_id;
        }

        $guest = User::create([
            'full_name' => $request->full_name ?: 'Khách vãng lai',
            'phone_number' => $request->phone_number,
            'email' => $request->email ?: ('guest_' . now()->timestamp . '@guest.local'),
            'password_hash' => bcrypt('guest_' . now()->timestamp),
            'role_id' => 4,
            'status' => 1,
        ]);

        return $guest->user_id;
    }
}
