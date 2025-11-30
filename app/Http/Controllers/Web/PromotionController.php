<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = Promotion::orderByDesc('promotion_id');

        if ($request->filled('keyword')) {
            $query->where('code', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $promotions = $query->paginate(10);

        return view('admin.promotions.index', compact('promotions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required',
            'description' => 'required',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date'
        ]);

        $data['is_active'] = 1;

        Promotion::create($data);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Thêm khuyến mãi thành công');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return back()->with('success', 'Đã xóa');
    }

    public function toggle($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        return back();
    }

    public function edit(Promotion $promotion)
    {
        return response()->json($promotion);
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $promotion->code = $request->code ?? $promotion->code;
        $promotion->description = $request->description ?? $promotion->description;
        $promotion->discount_percent = $request->discount_percent ?? $promotion->discount_percent;
        $promotion->valid_from = $request->valid_from ?? $promotion->valid_from;
        $promotion->valid_to = $request->valid_to ?? $promotion->valid_to;

        $promotion->save();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Cập nhật khuyến mãi thành công');
    }


}
