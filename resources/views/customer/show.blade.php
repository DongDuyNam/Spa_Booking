@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-pink-700 font-bold">Chi tiết khách hàng</h2>

    <div class="card p-4 bg-white shadow rounded">
        <p><strong>Họ tên:</strong> {{ $customer->full_name }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
        <p><strong>Số điện thoại:</strong> {{ $customer->phone_number }}</p>
        <p><strong>Ngày tạo:</strong> {{ $customer->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Trạng thái:</strong> {{ $customer->status == 1 ? 'Hoạt động' : 'Ngừng hoạt động' }}</p>

        <a href="{{ route('customer.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
    </div>
</div>
@endsection
