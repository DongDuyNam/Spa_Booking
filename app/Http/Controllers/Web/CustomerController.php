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
        $query = User::where('role_id', 3);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('full_name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('phone_number', 'like', "%$keyword%");
            });
        }

        $customers = $query->orderByDesc('user_id')->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function destroy($id)
    {
        try {
            $customer = User::findOrFail($id);
            $customer->delete();

            return redirect()
                ->route('admin.customers.index')
                ->with('success', "Đã xóa khách hàng #{$id} và toàn bộ dữ liệu liên quan.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->with('error', "Không tìm thấy khách hàng với ID: {$id}");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi khi xóa khách hàng: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone_number'  => 'nullable|string|max:20',
            'gender'        => 'nullable|string|max:10',
            'branch_id'     => 'nullable|integer',
        ]);

        $customer = new User();
        $customer->full_name     = $request->full_name;
        $customer->email         = $request->email;
        $customer->phone_number  = $request->phone_number;
        $customer->gender        = $request->gender;
        $customer->branch_id     = $request->branch_id;
        $customer->role_id       = 3; 
        $customer->status        = 1;
        $customer->password_hash      = bcrypt('123456'); 
        $customer->save();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Thêm khách hàng mới thành công!');
    }

    public function update(Request $request, $id)
{
    // 1. Tìm khách hàng
    $customer = User::findOrFail($id);

    // 2. Xác thực dữ liệu
    $request->validate([
        'full_name'     => 'required|string|max:255',
        // Đảm bảo email là duy nhất, nhưng loại trừ chính email của khách hàng đang chỉnh sửa
        'email'         => 'required|email|unique:users,email,' . $customer->user_id . ',user_id', 
        'phone_number'  => 'nullable|string|max:20',
        'gender'        => 'nullable|string|max:10',
        'branch_id'     => 'nullable|integer',
        'status'        => 'required|integer|in:0,1', // Thêm validation cho status
    ]);

    // 3. Cập nhật dữ liệu
    $customer->full_name     = $request->full_name;
    $customer->email         = $request->email;
    $customer->phone_number  = $request->phone_number;
    $customer->gender        = $request->gender;
    $customer->branch_id     = $request->branch_id;
    $customer->status        = $request->status; // Cập nhật trạng thái
    // Bỏ qua password_hash vì bạn không có trường mật khẩu trong form chỉnh sửa
    $customer->save();

    return redirect()
        ->route('admin.customers.index')
        ->with('success', "Cập nhật thông tin khách hàng #{$id} thành công!");
}
}


