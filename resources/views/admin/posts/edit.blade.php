<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Preview gambar lama --}}
                @if ($post->image)
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Gambar Saat Ini</label>
                        <img src="{{ asset('storage/' . $post->image) }}" class="w-48 rounded border">
                    </div>
                @endif

                {{-- Upload gambar baru --}}
                <div class="mb-4">
                    <label for="image" class="block font-medium text-sm text-gray-700">Gambar Baru (Opsional)</label>
                    <input type="file" name="image" id="image" onchange="previewImage()" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <img id="image-preview" class="mt-2 h-32 rounded border" style="display: none;" />
                    @error('image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="block font-medium text-sm text-gray-700">Judul</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ old('title', $post->title) }}" required>
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="slug" class="block font-medium text-sm text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        value="{{ old('slug', $post->slug) }}" required>
                    @error('slug') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="body" class="block font-medium text-sm text-gray-700">Isi Berita</label>
                    <textarea name="body" id="body" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('body', $post->body) }}</textarea>
                    @error('body') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('posts.index') }}" class="text-sm text-gray-600 hover:underline mr-4">Batal</a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>

            {{-- Scripts --}}
            <script>
                // Preview gambar baru
                function previewImage() {
                    const input = document.getElementById('image');
                    const preview = document.getElementById('image-preview');

                    const file = input.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        preview.style.display = 'none';
                    }
                }

                // Auto slug
                document.getElementById('title').addEventListener('input', function () {
                    const title = this.value;
                    const slug = title.toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/(^-|-$)+/g, '');
                    document.getElementById('slug').value = slug;
                });

                // CKEditor
                CKEDITOR.replace('body');
            </script>
            <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
        </div>
    </div>
</x-app-layout>
