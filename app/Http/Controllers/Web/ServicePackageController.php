<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    public function index(Request $request)
    {
        $query = ServicePackage::orderByDesc('package_id');

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where('name', 'like', "%{$keyword}%");
        }

        $packages = $query->paginate(10)->withQueryString();

        return view('admin.servicepackages.index', compact('packages'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'limit_usage' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'required|integer|in:0,1',
        ]);

        $data = $request->all();

        // Xử lý upload file
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('thumbnails', $filename, 'public');

            $data['thumbnail'] = $path;
        }

        ServicePackage::create($data);

        return back()->with('success', 'Thêm gói dịch vụ thành công!');
    }


    public function update(Request $request, $id)
    {
        $package = ServicePackage::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
            'limit_usage' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'required|integer|in:0,1',
        ]);

        $data = $request->all();

        // Upload ảnh mới (nếu có)
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('thumbnails', $filename, 'public');

            $data['thumbnail'] = $path;
        }

        $package->update($data);

        return back()->with('success', 'Cập nhật gói dịch vụ thành công!');
    }

    public function destroy($id)
    {
        $package = ServicePackage::findOrFail($id);

        if ($package->thumbnail) {
            Storage::disk('public')->delete($package->thumbnail);
        }

        $package->delete();

        return redirect()
            ->route('admin.servicepackages.index')
            ->with('success', 'Đã xóa gói dịch vụ!');
    }
}