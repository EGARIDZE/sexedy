<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Admin\AbstractAPIResponse;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends AbstractAPIResponse
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->get();
        return $products;
    }

    public function show($id)
    {
        $product = Product::with(['category', 'brand'])->find($id);
        if (!$product) {
            return $this->findOrFailItem(false, 'Product not found', null, 404);
        }
        return $product;
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return response()->json([
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return $this->findOrFailItem(false, $validator->errors(), null, 422);
        }
        $validated = $validator->validated();

        $product = Product::create($validated);

        return $this->findOrFailItem(true, 'Poduct created succesfuly', $product, 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->findOrFailItem(false, 'Product not found', null, 422);
        }

        $product->delete();
        return $this->findOrFailItem(true, 'Product deleted successfully', null, 200);
    }
}