<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['customer', 'staff', 'branch']);

        // 🔍 Tìm kiếm theo tên khách hàng hoặc nhân viên
        if ($search = $request->input('search')) {
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })->orWhereHas('staff', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // 🧩 Filter theo trạng thái
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // 🧩 Filter theo chi nhánh
        if ($branchId = $request->input('branch_id')) {
            $query->where('branch_id', $branchId);
        }

        // 🧩 Filter theo khách hàng hoặc nhân viên
        if ($customerId = $request->input('customer_id')) {
            $query->where('customer_id', $customerId);
        }

        if ($staffId = $request->input('staff_id')) {
            $query->where('staff_id', $staffId);
        }

        // 🧭 Filter theo khoảng thời gian
        if ($from = $request->input('from')) {
            $query->whereDate('scheduled_time', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('scheduled_time', '<=', $to);
        }

        // ↕️ Sắp xếp
        $sort = $request->input('sort', 'scheduled_time');
        $order = $request->input('order', 'asc');
        $query->orderBy($sort, $order);

        // 📄 Phân trang
        $limit = (int) $request->input('limit', 10);
        $appointments = $query->paginate($limit);

        return response()->json([
            'data' => $appointments->items(),
            'meta' => [
                'total' => $appointments->total(),
                'page' => $appointments->currentPage(),
                'limit' => $appointments->perPage(),
                'last_page' => $appointments->lastPage(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'staff_id' => 'nullable|exists:users,id',
            'branch_id' => 'required|exists:branches,branch_id',
            'scheduled_time' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => 'in:pending,confirmed,completed,cancelled',
        ]);

        $appointment = Appointment::create($validated);
        return response()->json($appointment, 201);
    }

    public function show($id)
    {
        $appointment = Appointment::with(['customer', 'staff', 'branch'])->findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'scheduled_time' => 'sometimes|date',
            'duration_minutes' => 'sometimes|integer|min:0',
            'total_amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
            'staff_id' => 'sometimes|exists:users,id',
            'branch_id' => 'sometimes|exists:branches,branch_id',
        ]);

        $appointment->update($validated);
        return response()->json($appointment);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
