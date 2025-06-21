<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <article class="bg-white rounded-lg shadow p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                {{ $post->title }}
            </h1>

            <div class="text-sm text-gray-500 mb-4">
                Dipublikasikan pada {{ $post->created_at->format('d M Y') }} |
                Kategori:
                <a href="{{ route('posts.byCategory', $post->category->slug) }}" class="text-blue-500 hover:underline">
                    {{ $post->category->name ?? 'Tanpa Kategori' }}
                </a>
            </div>

            @if ($post->thumbnail)
                <img
                    src="{{ asset('storage/' . $post->thumbnail) }}"
                    alt="{{ $post->title }}"
                    class="w-full max-h-[450px] object-cover rounded mb-6"
                    onerror="this.onerror=null;this.src='https://via.placeholder.com/800x400?text=No+Image';"
                >
            @endif

            <div class="prose max-w-none text-gray-800">
                {!! $post->body !!}
            </div>
        </article>

        <h3 class="text-xl font-bold mt-6">Komentar</h3>

        @foreach ($post->comments as $comment)
            <div class="mt-2 p-4 bg-gray-100 rounded">
                <strong>{{ $comment->user->name ?? 'Anonim' }}</strong>
                <p>{{ $comment->content }}</p>
                <small class="text-sm text-gray-600">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        @endforeach

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mt-4">
                {{ session('success') }}
            </div>
        @endif

        @auth
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-6">
                @csrf
                <textarea name="content" rows="4" class="w-full p-3 border border-gray-300 rounded" placeholder="Tulis komentar..."></textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kirim Komentar</button>
            </form>
        @else
            <p class="mt-4 text-gray-600">
                Silakan <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> untuk mengirim komentar.
            </p>
        @endauth

        <div class="mt-6">
            <a href="{{ route('home') }}" class="text-blue-500 hover:underline">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</x-app-layout>
