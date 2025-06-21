<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Hasil Pencarian: "{{ request('q') }}"</h1>

        @if ($posts->count())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-md transition">
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <img
                                src="{{ asset('storage/' . $post->thumbnail) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-48 object-cover"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/600x400?text=No+Image';"
                            >
                        </a>
                        <div class="p-4">
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <h2 class="text-lg font-semibold hover:text-blue-600">
                                    {{ $post->title }}
                                </h2>
                            </a>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $post->category->name ?? 'Tanpa Kategori' }} | {{ $post->created_at->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                {{ Str::limit(strip_tags($post->body), 100) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->withQueryString()->links() }}
            </div>
        @else
            <p class="text-gray-600">Tidak ada hasil untuk pencarian "{{ request('q') }}".</p>
        @endif

        <a href="{{ route('home') }}" class="text-blue-500 mt-6 inline-block hover:underline">
            ← Kembali ke Beranda
        </a>
    </div>
</x-app-layout>
