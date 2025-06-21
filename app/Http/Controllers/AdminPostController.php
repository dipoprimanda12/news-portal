<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPostController extends Controller
{
    // Tampilkan semua berita
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::latest()->get()
        ]);
    }

    // Tampilkan form tambah berita
    public function create()
    {
        return view('admin.posts.create', [
            'categories' => Category::all()
        ]);
    }

    // Simpan berita baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|max:255',
            'slug'        => 'required|unique:posts',
            'category_id' => 'required|exists:categories,id',
            'body'        => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['user_id'] = auth()->id();

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('post-images', 'public');
        }

        Post::create($validated);

        return redirect('/admin/posts')->with('success', 'Berita berhasil ditambahkan');
    }

    // Tampilkan form edit berita
    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    // Simpan perubahan berita
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'       => 'required|max:255',
            'slug'        => 'required|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'body'        => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada gambar baru, hapus gambar lama dan simpan yang baru
        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $validated['image'] = $request->file('image')->store('post-images', 'public');
        }

        $post->update($validated);

        return redirect('/admin/posts')->with('success', 'Berita berhasil diubah');
    }

    // Hapus berita
    public function destroy(Post $post)
    {
        // Hapus gambar jika ada
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect('/admin/posts')->with('success', 'Berita berhasil dihapus');
    }
}
