<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['categories', 'user'])->latest()->paginate(15);
        $totalPosts = Post::count();
        $totalCategories = Category::count();
        $categoryCounts = Category::withCount('posts')->orderByDesc('posts_count')->get();
        $totalViews = Post::sum('views_count');

        return view('admin.posts.index', compact('posts', 'totalPosts', 'totalCategories', 'categoryCounts', 'totalViews'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'featured_image' => 'nullable|image|max:10240',
            'is_published' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = ImageHelper::convertToWebp($request->file('featured_image'), 'posts', 80, 1200);
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ]);

        if (!empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.form', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'featured_image' => 'nullable|image|max:10240',
            'is_published' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->boolean('is_published') && !$post->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = ImageHelper::convertToWebp($request->file('featured_image'), 'posts', 80, 1200);
        }

        $post->update($data);
        $post->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Artikel dipindahkan ke tempat sampah.');
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()->with(['categories', 'user'])->latest('deleted_at')->paginate(15);
        return view('admin.posts.trash', compact('posts'));
    }

    public function restore(int $id)
    {
        Post::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.posts.trash')->with('success', 'Artikel berhasil dipulihkan.');
    }

    public function forceDelete(int $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->categories()->detach();
        $post->forceDelete();
        return redirect()->route('admin.posts.trash')->with('success', 'Artikel dihapus permanen.');
    }
}
