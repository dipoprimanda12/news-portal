<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Berita') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol tambah berita --}}
            <a href="{{ route('posts.create') }}"
               class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Tambah Berita
            </a>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel daftar berita --}}
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full text-sm text-left text-gray-800">
                    <thead class="bg-gray-100 font-bold">
    <tr>
        <th class="px-4 py-2">Judul</th>
        <th class="px-4 py-2">Kategori</th>
        <th class="px-4 py-2">Penulis</th>
        <th class="px-4 py-2">Tanggal</th>
        <th class="px-4 py-2">Gambar</th>
        <th class="px-4 py-2">Aksi</th>
    </tr>
</thead>
<tbody>
    @forelse ($posts as $post)
        <tr class="border-t">
            <td class="px-4 py-2">
                <strong>{{ $post->title }}</strong><br>
                <span class="text-xs text-gray-500">{{ Str::limit(strip_tags($post->body), 60) }}</span>
            </td>
            <td class="px-4 py-2">{{ $post->category->name }}</td>
            <td class="px-4 py-2">{{ $post->user->name }}</td>
            <td class="px-4 py-2 text-sm text-gray-500">{{ $post->created_at->format('d M Y') }}</td>
            <td class="px-4 py-2">
                @if($post->image)
                    <img src="{{ $post->image_url }}" alt="Gambar" class="h-12 w-auto rounded">
                @else
                    <span class="text-gray-400 italic">Tidak ada</span>
                @endif
            </td>
            <td class="px-4 py-2">
                <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-600 hover:underline">Edit</a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus berita ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">Belum ada berita.</td>
        </tr>
    @endforelse
</tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>
