<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class BaseController extends Controller
{
    protected $model;

    public function index($id)
    {
        $details = $this->model::where('product_id', $id)->get();
        return $details;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->findOrFail(false, 'Enter correct parameters', null, 422);
        }

        $validated = $validator->validated();
        $detail = $this->model::create($validated);
        return $this->findOrFail(true, 'Detail added successfully', $detail, 200);
    }

    public function destroy($id, $detail_id)
    {
        $detail = $this->model::find($detail_id);
        if (!$detail) {
            return $this->findOrFail(false, 'Detail not found', null, 404);
        }

        $detail->delete();
        return $this->findOrFail(true, 'Detail was deleted', null, 200);
    }

    protected function findOrFail(bool $status, string|array $message, array|object $data = null, int $statusCode)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

}