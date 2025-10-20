<x-layout>
    <article class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
        <p class="mt-2 text-sm text-slate-500">
            Geplaatst {{ $post->created_at->format('d-m-Y H:i') }}
        </p>

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
                </div>
            @empty
                <p class="text-slate-600">Nog geen reacties.</p>
            @endforelse
        </div>

    </article>
</x-layout>