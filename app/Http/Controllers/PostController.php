<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // Get all posts, latest first, with their authors and comment counts
        $posts = Post::with('user')->withCount('comments')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function preview(Request $request)
    {
        // Validate file size (max 10MB)
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB in kilobytes
        ]);

        // Forward to Flask API
        $response = Http::timeout(60) // Increase timeout for large files
            ->attach(
                'image',
                file_get_contents($request->file('image')->getRealPath()),
                $request->file('image')->getClientOriginalName()
            )->post('http://209.97.167.159/meme', [
                'top' => $request->input('top', ''),
                'bottom' => $request->input('bottom', ''),
            ]);

        if ($response->successful()) {
            return response($response->body())
                ->header('Content-Type', 'image/png');
        }

        return response()->json(['error' => 'Failed to generate meme'], 500);
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'nullable',
            'top_text' => 'nullable|max:255',
            'bottom_text' => 'nullable|max:255',
            'meme_data' => 'required', // Base64 encoded image
        ]);

        // Decode base64 image
        $imageData = $request->input('meme_data');
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $decoded = base64_decode($imageData);

        // Save to storage
        $filename = 'memes/' . uniqid() . '_' . time() . '.png';
        Storage::disk('public')->put($filename, $decoded);

        // Create post
        $request->user()->posts()->create([
            'title' => $validated['title'],
            'body' => $validated['body'] ?? '',
            'top_text' => $validated['top_text'],
            'bottom_text' => $validated['bottom_text'],
            'image_path' => $filename,
        ]);

        return redirect()->route('posts.index')->with('success', 'Meme posted successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        // Create post associated with current user
        $request->user()->posts()->create($validated);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        // Ensure user owns the post or is admin
        if ($post->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Ensure user owns the post or is admin
        if ($post->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'nullable',
        ]);

        $post->update($validated);

        return redirect()->route('profile.show')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Ensure user owns the post or is admin
        if ($post->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        // Delete image file if exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }

    public function show(Post $post)
    {
        // Load post with user, comments, and comment authors
        $post->load(['user', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|max:1000',
        ]);

        $post->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Comment added!');
    }

    public function destroyComment(Comment $comment)
    {
        // Ensure user owns the comment or is admin
        if ($comment->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted!');
    }
}
