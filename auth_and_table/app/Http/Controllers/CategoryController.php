<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::get();
        return response()->json([
            'status' => 'success',
            'data' => CategoryResource::collection($data)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create([
            'name'  => $request->input('name')]);
        return response()->json([
        'status' => 'success',
        'message' => 'Category created successfully'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => 'failed',
                'message' => 'Category Not Found'
            ],404);
        }else{
            return response()->json([
                'status' => 'success',
                'message' => 'Category find successfully',
                'data' => new CategoryResource($category)
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => 'failed',
                'message' => 'Category Not Found'
            ],404);

        }else{
            $category->update([
                'name' => $request->input('name')
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Category Updated Successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found'
            ],404);
        }else{
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Category delete successfully'
            ]);
        }
    }
}
