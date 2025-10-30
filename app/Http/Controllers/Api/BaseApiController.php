<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

abstract class BaseApiController extends Controller
{
    protected string $modelClass;

    public function index()
    {
        $data = ($this->modelClass)::paginate(10);
        return response()->json($data);
    }

    public function show($id)
    {
        $item = ($this->modelClass)::find($id);
        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
        }
        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = ($this->modelClass)::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = ($this->modelClass)::find($id);
        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
        }
        $item->update($request->all());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = ($this->modelClass)::find($id);
        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu'], 404);
        }
        $item->delete();
        return response()->json(['message' => 'Đã xóa thành công']);
    }
}
