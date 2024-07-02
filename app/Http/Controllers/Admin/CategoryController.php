<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends AbstractAPIResponse
{
    public function index()
    {
        $categories = Category::with('subCategories')->get();
        return response()->json($categories);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->findOrFailItem(false, 'Category not found', null, 404);
        }

        $category->delete();
        return $this->findOrFailItem(true, 'Category removed', null, 200);
    }

    public function create()
    {
        return Category::pluck('id', 'name')->all();
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validated->fails()) {
            return $this->findOrFailItem(false, 'Enter correct parameters', $validated->errors(), 422);
        }

        $createCategory = Category::create($request->all());
        return $this->findOrFailItem(true, 'Category was created', null, 201);
    }

    public function edit($id)
    {
        $category = Category::with('parentCategory')->find($id);
        $cateogories = Category::pluck('id', 'name')->all();
        return response()->json([
            'current-category' => $category,
            'all-categories' => $cateogories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validated->fails()) {
            return $this->findOrFailItem(false, 'Validation errors', $validated->errors(), 422);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->save();

        return $this->findOrFailItem(true, 'Category updated successfully', null, 200);
    }
}