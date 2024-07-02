<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends AbstractAPIResponse
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

        if ($validator->fails()) {
            return $this->findOrFailItem(false, $validator->errors(), null, 422);
        }

        $brand = Brand::create([
            'name' => $request->input('name'),
        ]);
        return $this->findOrFailItem(true, 'Brand created succesfuly', $brand, 201);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return $this->findOrFailItem(false, 'Brand not found', null, 404);
        };

        $brand->delete();
        return $this->findOrFailItem(true, 'Brand removed successfully', null, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:brands,name', 'max:255'],
        ]);

        if ($validator->fails()) {
            return $this->findOrFailItem(false, $validator->errors(), null, 422);
        }

        $brand = Brand::find($id);
        if (!$brand) {
            return $this->findOrFailItem(false, 'Brand not found', null, 404);
        }

        $brand->name = $request->input('name');
        $brand->save();

        return $this->findOrFailItem(true, 'Brand successfully updated', null, 201);
    }
}