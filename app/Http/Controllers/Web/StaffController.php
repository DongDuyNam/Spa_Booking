<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Danh sách nhân viên
     */
    public function index(Request $request)
    {
        $query = Staff::with('user')->orderByDesc('staff_id');

        // Lọc theo từ khóa
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('full_name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('phone_number', 'like', "%$keyword%");
            });
        }

        // LỌC THEO CHI NHÁNH
        if ($request->filled('branch_id')) {
            $branchId = $request->branch_id;

            $query->whereHas('user', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $staffs = $query->paginate(10);

        return view('admin.staffs.index', compact('staffs'));
    }

    /**
     * Form thêm nhân viên
     */
    public function create()
    {
        // Lấy danh sách user có role_id = 2 (Nhân viên)
        $users = User::where('role_id', 2)->get();

        return view('admin.staffs.create', compact('users'));
    }

    /**
     * Lưu nhân viên mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'branch_id' => 'nullable|integer',

            // STAFF fields
            'specialization' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'required|date',
            'status' => 'required|integer|in:0,1',
        ]);

        // 1) Tạo User
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'branch_id' => $request->branch_id,
            'role_id' => 2, // Nhân viên
            'status' => $request->status,
            'password_hash' => bcrypt('123456'),
        ]);

        // 2) Tạo Staff
        Staff::create([
            'user_id' => $user->user_id,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'salary' => $request->salary,
            'hire_date' => $request->hire_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.staffs.index')
            ->with('success', 'Thêm nhân viên thành công!');
    }

    /**
     * Xem chi tiết nhân viên
     */
    public function show($id)
    {
        $staff = Staff::with('user')->findOrFail($id);

        return view('admin.staffs.show', compact('staff'));
    }

    /**
     * Form chỉnh sửa nhân viên
     */
    public function edit($id)
    {
        $staff = Staff::with('user')->findOrFail($id);
        $users = User::where('role_id', 2)->get();

        return view('admin.staffs.edit', compact('staff', 'users'));
    }

    /**
     * Update nhân viên
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $user = $staff->user;

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'branch_id' => 'nullable|integer',

            // Staff
            'specialization' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'required|date',
            'status' => 'required|integer|in:0,1',
        ]);

        // Update User
        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'branch_id' => $request->branch_id,
            'status' => $request->status,
        ]);

        // Update Staff
        $staff->update([
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'salary' => $request->salary,
            'hire_date' => $request->hire_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.staffs.index')
            ->with('success', 'Cập nhật nhân viên thành công!');
    }

    /**
     * Xóa nhân viên
     */
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $user = $staff->user;

        $staff->delete();
        $user->delete();

        return back()->with('success', 'Đã xóa nhân viên!');
    }

}
