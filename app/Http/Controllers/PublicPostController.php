<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class PublicPostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(5);

        return view('public.home', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('public.show', compact('post'));
    }

    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->latest()->paginate(5);

        return view('public.category', compact('category', 'posts'));
    }

    public function search()
    {
        $keyword = request('q');
        $posts = Post::where('title', 'like', "%$keyword%")
                    ->orWhere('body', 'like', "%$keyword%")
                    ->latest()
                    ->paginate(5);

        return view('public.search', compact('posts', 'keyword'));
    }

}
