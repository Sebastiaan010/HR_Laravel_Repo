<x-layout>
    <article class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
        <p class="mt-2 text-sm text-slate-500">
            Geplaatst {{ $post->created_at->format('d-m-Y H:i') }}
            • door {{ $post->user->name ?? 'anoniem' }}
        </p>

        @if($post->category)
            <div class="mt-3">
                <span class="inline-block text-xs px-2 py-1 rounded-full bg-slate-200 text-slate-700">
                    {{ ucfirst($post->category) }}
                </span>
            </div>
        @endif

        <div class="mt-2 flex gap-3 text-sm">
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="underline">Bewerken</a>
            @endcan
            @can('delete', $post)
                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-600 underline" onclick="return confirm('Verwijderen?')">
                        Verwijderen
                    </button>
                </form>
            @endcan
        </div>

        @if($post->image_path)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Afbeelding bij {{ $post->title }}"
                    class="w-full rounded-lg border">
            </div>
        @endif

        <div class="prose max-w-none mt-6">
            {{ $post->body }}
        </div>

        <hr class="my-6">

        <h2 class="text-xl font-semibold">
            Reacties ({{ $post->comments->count() }})
        </h2>

        <div class="mt-4 space-y-4">
            @forelse($post->comments as $c)
                <div class="bg-white border rounded p-4">
                    <div class="text-xs text-slate-500 mb-1">
                        {{ $c->user->name ?? 'anoniem' }} • {{ $c->created_at->diffForHumans() }}
                    </div>
                    <p>{{ $c->body }}</p>

                    @auth
                        @if($c->user_id === auth()->id() || auth()->user()->role === 'admin')
                            <form method="POST" action="{{ route('comments.destroy', $c) }}" class="mt-2">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-600 underline" onclick="return confirm('Reactie verwijderen?')">
                                    Verwijder
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <p class="text-slate-600">Nog geen reacties.</p>
            @endforelse
        </div>

        @if (session('success'))
            <div class="mt-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded px-3 py-2">
                {{ session('success') }}
            </div>
        @endif

        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-6 space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Je reactie</label>
                    <textarea name="body" rows="4"
                        class="mt-1 w-full rounded border border-slate-300 px-3 py-2">{{ old('body') }}</textarea>
                    @error('body') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <button class="px-4 py-2 rounded bg-blue-600 text-white">Plaatsen</button>
            </form>
        @else
            <p class="mt-6 text-sm">
                <a class="text-blue-600 underline" href="{{ route('login') }}">Log in</a> om te reageren.
            </p>
        @endauth

    </article>
</x-layout>
