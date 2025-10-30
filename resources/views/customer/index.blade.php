@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Danh sách khách hàng</h2>

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border p-2">#</th>
            <th class="border p-2">Họ tên</th>
            <th class="border p-2">Email</th>
            <th class="border p-2">Ngày tạo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $c)
            <tr>
                <td class="border p-2">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $c->full_name }}</td>
                <td class="border p-2">{{ $c->email }}</td>
                <td class="border p-2">{{ $c->created_at->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
