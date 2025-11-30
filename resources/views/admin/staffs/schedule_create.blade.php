<form method="POST" action="{{ route('admin.schedules.store') }}" class="space-y-4">
    @csrf

    <input type="hidden" name="staff_id" value="{{ old('staff_id') }}">

    <div>
        <label>Ngày làm</label>
        <input type="date" name="work_date" class="border px-3 py-2 w-full" required>
    </div>

    <div>
        <label>Ca làm</label>
        <select name="shift" class="border px-3 py-2 w-full" required>
            <option value="Sáng">Sáng</option>
            <option value="Chiều">Chiều</option>
            <option value="Tối">Tối</option>
            <option value="Full time">Full time</option>
        </select>
    </div>

    <div>
        <label>Giờ bắt đầu</label>
        <input type="time" name="start_time" class="border px-3 py-2 w-full" required>
    </div>

    <div>
        <label>Giờ kết thúc</label>
        <input type="time" name="end_time" class="border px-3 py-2 w-full" required>
    </div>

    <div>
        <label>Ghi chú</label>
        <textarea name="notes" class="border px-3 py-2 w-full"></textarea>
    </div>

    <button class="bg-pink-500 text-white px-4 py-2 rounded">
        Lưu lịch
    </button>
</form>
