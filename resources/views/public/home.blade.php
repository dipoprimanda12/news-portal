<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Berita Terbaru</h1>

        @if ($posts->count())
            @foreach ($posts as $post)
                <div class="mb-8">
                    <a href="{{ route('posts.show', $post->slug) }}" class="text-xl font-semibold text-blue-600 hover:underline">
                        {{ $post->title }}
                    </a>
                    <div class="text-sm text-gray-500 mb-2">
                        Dipublikasikan pada {{ $post->created_at->format('d M Y') }} |
                        Kategori: {{ $post->category->name ?? 'Tanpa Kategori' }}
                    </div>

                    @if ($post->thumbnail)
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="rounded-lg mb-2 max-h-[300px] object-cover w-full">
                    @endif

                    <p class="text-gray-700">{!! Str::limit(strip_tags($post->body), 150) !!}</p>
                </div>
            @endforeach

            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-gray-500">Tidak ada berita yang ditemukan.</p>
        @endif
    </div>
</x-app-layout>
