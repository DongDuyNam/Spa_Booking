<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role_id', 3); // chỉ lấy khách hàng

        // --- Lọc theo từ khóa ---
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('full_name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('phone_number', 'like', "%$keyword%");
            });
        }

        // --- Lọc theo chi nhánh ---
        if ($request->filled('branch_id')) {
            $branchId = $request->branch_id;
            $query->where('branch_id', $branchId);
        }

        // Giữ tham số khi phân trang
        $customers = $query->orderByDesc('user_id')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.customers.index', compact('customers'));
    }


    public function show($id)
    {
        $customer = User::with('customerData')->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = User::with('customerData')->findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // Xóa bảng customers
            \App\Models\Customer::where('user_id', $id)->delete();

            // Xóa user
            $user->delete();

            DB::commit();

            return redirect()
                ->route('admin.customers.index')
                ->with('success', "Đã xóa khách hàng #{$id}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi xóa khách hàng: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'branch_id' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {

            // 1. Tạo user
            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'branch_id' => $request->branch_id,
                'role_id' => 3,
                'status' => 1,
                'password_hash' => bcrypt('123456'),
            ]);

            // 2. Tạo bản ghi customer
            \App\Models\Customer::create([
                'user_id' => $user->user_id,
                'loyal_points' => 0,
                'note' => '',
            ]);

            DB::commit();

            return redirect()
                ->route('admin.customers.index')
                ->with('success', 'Thêm khách hàng mới thành công!');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Lỗi khi thêm: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // 1. Tìm khách hàng
        $customer = User::findOrFail($id);

        // 2. Xác thực dữ liệu
        $request->validate([
            'full_name' => 'required|string|max:255',
            // Đảm bảo email là duy nhất, nhưng loại trừ chính email của khách hàng đang chỉnh sửa
            'email' => 'required|email|unique:users,email,' . $customer->user_id . ',user_id',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'branch_id' => 'nullable|integer',
            'status' => 'required|integer|in:0,1', // Thêm validation cho status
        ]);

        // 3. Cập nhật dữ liệu
        $customer->full_name = $request->full_name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->gender = $request->gender;
        $customer->branch_id = $request->branch_id;
        $customer->status = $request->status; // Cập nhật trạng thái
        // Bỏ qua password_hash vì bạn không có trường mật khẩu trong form chỉnh sửa
        $customer->save();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', "Cập nhật thông tin khách hàng #{$id} thành công!");
    }
}


