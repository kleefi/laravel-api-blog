<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::where('user_id', auth()->id())->paginate(10);
        $posts = Post::with('user')->paginate(10);
        return PostResource::collection($posts)->additional([
            'meta' => [
                'api_version' => '1.0',
                'generated_at' => now()->toIso8601String(),
            ]
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "string|required|max:60",
            "body" => "string|required|min:6",
        ]);

        if (!$validated) {
            return response()->json([
                "status" => false,
                "message" => $validated
            ], 422);
        }
        $post = Post::create([
            "title" => $request->title,
            "body" => $request->body,
            "user_id" => auth()->id(),
            "category_id" => $request->category_id

        ]);
        return response()->json([
            "status" => true,
            "message" => "post created",
            "data" => new PostResource($post)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('user')->find($id);
        if (!$post) {
            return response()->json([
                "message" => "post not found"
            ], 404);
        }
        // if ($post->user_id !== auth()->id()) {
        //     return response()->json([
        //         "message" => "Unauthorized"
        //     ], 403);
        // }
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                "message" => "Unauthorized"
            ], 403);
        }
        $validated = $request->validate([
            "title" => "string|required",
            "body" => "string|required|min:6",
            "category_id" => "required",
        ]);
        $post->update($validated);
        return response()->json([
            "message" => "updated",
            "data" => new PostResource($post)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json([
            "status" => true,
            "message" => "post deleted"
        ], 200);
    }
}
