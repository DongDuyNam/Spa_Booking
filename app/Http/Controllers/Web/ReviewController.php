<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('user')
            ->orderByDesc('review_id');

        // Lọc theo nội dung comment
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('comment', 'like', '%' . $keyword . '%');
        }

        // Lọc theo số sao
        if ($request->filled('rating')) {
            $query->where('rating', (int) $request->rating);
        }

        // Lọc theo trạng thái đã trả lời / chưa
        // is_replied: 0 = chưa rep, 1 = đã rep
        if ($request->filled('is_replied')) {
            $query->where('is_replied', (int) $request->is_replied);
        }

        // Lọc theo chi nhánh thông qua user.branch_id
        if ($request->filled('branch_id')) {
            $branchId = $request->branch_id;

            $query->whereHas('user', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $reviews = $query
            ->paginate(10)
            ->withQueryString();

        // Nếu anh có model Branch thì có thể load để đổ vào dropdown filter
        // $branches = Branch::all();

        // Nếu chưa cần filter chi nhánh bằng select, có thể chỉ trả về $reviews
        // return view('admin.reviews.index', compact('reviews'));

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            // 'branches' => $branches ?? [],
        ]);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Cập nhật đánh giá thành công');
    }

    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'reply_content' => 'required|string'
        ]);

        $review->reply_content = $request->reply_content;
        $review->is_replied = 1;
        $review->replied_at = now();
        $review->replied_by = auth()->id();
        $review->save();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Đã phản hồi đánh giá');
    }


    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Đã xóa đánh giá');
    }


}
