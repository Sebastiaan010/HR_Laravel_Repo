<x-layout>
    <h1 class="text-2xl font-bold mb-4">Post bewerken</h1>

    @if ($errors->any())
        <ul class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded px-3 py-2">
            @foreach ($errors->all() as $e) <li>• {{ $e }}</li> @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data"
        class="max-w-xl space-y-3">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm mb-1">Titel</label>
            <input name="title" class="border rounded w-full px-3 py-2" value="{{ old('title', $post->title) }}">
        </div>

        <div>
            <label class="block text-sm mb-1">Categorie</label>
            <select name="category" class="border rounded px-3 py-2">
                <option value="">— kies —</option>
                @foreach(['algemeen', 'ruil', 'deck', 'waarde'] as $cat)
                    <option value="{{ $cat }}" @selected(old('category', $post->category ?? '') === $cat)>{{ ucfirst($cat) }}
                    </option>
                @endforeach
            </select>
        </div>


        <div>
            <label class="block text-sm mb-1">Bericht</label>
            <textarea name="body" rows="6"
                class="border rounded w-full px-3 py-2">{{ old('body', $post->body) }}</textarea>
        </div>

        <div>
            <label class="block text-sm mb-1">Afbeelding (optioneel)</label>
            @if($post->image_path)
                <img src="{{ asset('storage/' . $post->image_path) }}" class="w-40 h-28 object-cover border rounded mb-2"
                    alt="">
            @endif
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 rounded bg-blue-600 text-white">Opslaan</button>
            <a href="{{ route('posts.show', $post) }}" class="px-4 py-2 rounded border">Annuleren</a>
        </div>
    </form>
</x-layout>