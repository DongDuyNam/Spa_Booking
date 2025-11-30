<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Danh sách dịch vụ + lọc + phân trang
     */
    public function index(Request $request)
    {
        // Lấy danh mục DISTINCT
        $categories = Service::select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $query = Service::query();

        if ($request->filled('keyword')) {
            $k = $request->keyword;
            $query->where(function ($q) use ($k) {
                $q->where('name', 'like', "%$k%")
                    ->orWhere('description', 'like', "%$k%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $services = $query->orderBy('service_id', 'desc')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.services.index', [
            'services' => $services,
            'categories' => $categories,
        ]);
    }


    /**
     * Form tạo mới
     */
    public function create()
    {
        return view('admin.services.create');
    }


    /**
     * Lưu dịch vụ mới
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration_minutes' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string|max:100',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'is_active' => 'required|integer|in:0,1',
    ]);

    $data = $request->only([
        'name', 'description', 'duration_minutes',
        'price', 'category', 'is_active'
    ]);

    // Xử lý thumbnail (nếu có)
    if ($request->hasFile('thumbnail')) {

        $file = $request->file('thumbnail');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Lưu vào storage/app/public/thumbnails
        $path = $file->storeAs('thumbnails', $filename, 'public');

        $data['thumbnail'] = $path;
    }

    Service::create($data);

    return redirect()
        ->route('admin.services.index')
        ->with('success', 'Thêm dịch vụ mới thành công!');
}



    /**
     * Form chỉnh sửa
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }


    /**
     * Xử lý cập nhật
     */
    public function update(Request $request, $id)
{
    $service = Service::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration_minutes' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string|max:100',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'is_active' => 'required|integer|in:0,1',
    ]);

    $data = $request->only([
        'name', 'description', 'duration_minutes',
        'price', 'category', 'is_active'
    ]);

    if ($request->hasFile('thumbnail')) {

        $file = $request->file('thumbnail');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('thumbnails', $filename, 'public');

        $data['thumbnail'] = $path;
    }

    $service->update($data);

    return redirect()
        ->route('admin.services.index')
        ->with('success', "Cập nhật dịch vụ #{$id} thành công!");
}



    /**
     * Xóa dịch vụ
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $service = Service::findOrFail($id);

            $service->delete();

            DB::commit();

            return redirect()
                ->route('admin.services.index')
                ->with('success', "Đã xóa dịch vụ #{$id}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi xóa dịch vụ: ' . $e->getMessage());
        }
    }
}
