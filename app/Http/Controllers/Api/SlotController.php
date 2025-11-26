<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\ServicePackage;
use Carbon\Carbon;

class SlotController extends Controller
{
    public function getSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'services' => 'required|string',
            'package_id' => 'nullable|integer|exists:service_packages,package_id',
        ]);

        $date = $request->date;
        $serviceIds = array_filter(explode(',', $request->services));

        if (empty($serviceIds)) {
            return response()->json(['slots' => []]);
        }

        // --- TÍNH THỜI LƯỢNG ---
        if ($request->package_id) {
            $package = ServicePackage::find($request->package_id);

            if ($package && $package->duration_minutes > 0) {
                $duration = (int) $package->duration_minutes;
            } else {
                $duration = (int) Service::whereIn('service_id', $serviceIds)->sum('duration_minutes');
            }

        } else {
            $duration = (int) Service::whereIn('service_id', $serviceIds)->sum('duration_minutes');
        }

        if ($duration <= 0) $duration = 60;

        $open  = Carbon::parse("$date 09:00");
        $close = Carbon::parse("$date 21:00");

        $appointments = Appointment::whereDate('appointment_date', $date)
            ->whereNotNull('appointment_time')
            ->where('status', '!=', 'cancelled')
            ->get();

        $slots = [];
        $cursor = $open->copy();

        while ($cursor->lt($close)) {

            $start = $cursor->copy();
            $end   = $cursor->copy()->addMinutes($duration);

            if ($end->gt($close)) break;

            $overlap = false;

            foreach ($appointments as $appt) {
                $apptStart = Carbon::parse("$date {$appt->appointment_time}");
                $apptEnd   = $apptStart->copy()->addMinutes($appt->duration_minutes);

                if ($start->lt($apptEnd) && $end->gt($apptStart)) {
                    $overlap = true;
                    break;
                }
            }

            if (!$overlap) {
                $slots[] = $start->format('H:i');
            }

            $cursor->addMinutes(30);
        }

        return response()->json(['slots' => $slots]);
    }
}
