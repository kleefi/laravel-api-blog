<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "string|required|min:3"
        ]);
        $category = Category::create($validated);
        return new CategoryResource($category);
    }
    public function show(string $id)
    {
        $category = Category::find($id);
        return new CategoryResource($category);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "title" => "string|min:3"
        ]);
        $category = Category::find($id);
        $category->update($validated);
        return new CategoryResource($category);
    }
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
        $category->delete();
        return new CategoryResource($category);
    }
}
