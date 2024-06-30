<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:brands,name', 'max:255'],
        ]);

        if ($response = $this->getValidateAnswer($validator)) {
            return $response;
        }

        $brand = Brand::create([
            'name' => $request->input('name'),
        ]);
        return $this->findOrFailItem(true, $brand, 201);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return $this->findOrFailItem(false, 'Brand not found', 404);
        };

        $brand->delete();
        return $this->findOrFailItem(true, 'Brand removed successfully', 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:brands,name', 'max:255'],
        ]);

        if ($response = $this->getValidateAnswer($validator)) {
            return $response;
        }

        $brand = Brand::find($id);
        if (!$brand) {
            return $this->findOrFailItem(false, 'Brand not found', 404);
        }

        $brand->name = $request->input('name');
        $brand->save();

        return $this->findOrFailItem(true, 'Brand successfully updated', 201);
    }



    private function getValidateAnswer($validator)
    {
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 422);
        }
        return null;
    }

    private function findOrFailItem(bool $status, string|array $message, int $statusCode)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $statusCode);
    }
}