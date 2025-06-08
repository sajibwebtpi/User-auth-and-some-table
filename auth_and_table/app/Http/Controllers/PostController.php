<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Post::get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $user_id =$request->header('user_id');
        $filepath = null;
        if($request->hasFile('featured_image')){
            $file = $request->file('featured_image');
            $filename = $user_id.'_'.time().'_'.$file->getClientOriginalName();
            $filepath = $file->storeAs('uploads',$filename, 'public');        
            }

            $store = Post::create([
            'title' =>$request->input('title'),
            'content' => $request->input('content'),
            'featured_image' => $filepath,
            'user_id' => $user_id,
            'category_id' => $request->input('category_id')
            ]);
            return response()->json([
            'status' => 'success',
            'message' => 'Image upload successfully',
            'data' => $store
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                'status' => 'failed',
                'data' =>'Post not found'
            ],404);
        }else{
            return response()->json([
                'status' => 'success',
                'data' => $post
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */

public function update(Request $request, string $id)
{
    $post = Post::find($id);

    if (!$post) {
        return response()->json([
            'status' => 'failed',
            'message' => 'Post not found'
        ], 404);
    }

    $user_id = $request->header('user_id');

    // Update data array
    $data = [
        'title' => $request->input('title'),
        'content' => $request->input('content'),
        'user_id' => $user_id,
        'category_id' => $request->input('category_id')
    ];

    // Check if new image uploaded
    if ($request->hasFile('featured_image')) {
        // dd($post->featured_image); // 👉 এখানে বসাও
        $file = $request->file('featured_image');
        $filename = $user_id . '_' . time() . '_' . $file->getClientOriginalName();
        $filepath = $file->storeAs('uploads', $filename, 'public');

        // Delete old image if exists
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $data['featured_image'] = $filepath;
    }

    $post->update($data);

    return response()->json([
        'status' => 'success',
        'message' => $request->hasFile('featured_image') ? 'Image updated successfully' : 'Post updated successfully',
        'data' => $post
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if(!$post){
            return response()->json([
                'status' => 'failed',
                'message' => 'Post not found'
            ]);
        }

        if($post->featured_image && Storage::disk('public')->exists($post->featured_image)){
            Storage::disk('public')->delete($post->featured_image);
        }
        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ]);
    }
}
