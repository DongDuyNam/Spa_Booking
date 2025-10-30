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
}