<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->with(['categories', 'user']);

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        // Sorting
        switch ($request->get('sort', 'terbaru')) {
            case 'terlama':
                $query->oldest('published_at');
                break;
            case 'az':
                $query->orderBy('title', 'asc');
                break;
            case 'za':
                $query->orderBy('title', 'desc');
                break;
            default: // terbaru
                $query->latest('published_at');
                break;
        }

        $posts = $query->paginate(9)->appends($request->query());

        $categories = Category::withCount(['posts' => function ($q) {
            $q->published();
        }])->get();

        $selectedCategory = $request->filled('category')
            ? Category::where('slug', $request->category)->first()
            : null;

        return view('public.blog.index', compact('posts', 'categories', 'selectedCategory'));
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with(['categories', 'user'])
            ->firstOrFail();

        $relatedPosts = Post::published()
            ->whereHas('categories', function ($q) use ($post) {
                $q->whereIn('categories.id', $post->categories->pluck('id'));
            })
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        return view('public.blog.show', compact('post', 'relatedPosts'));
    }
}
