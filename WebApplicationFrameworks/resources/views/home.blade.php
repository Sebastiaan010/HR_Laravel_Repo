<x-layout>
  <h1 class="text-2xl font-bold mb-4">Laatste posts</h1>

  @forelse($posts as $post)
    <article class="mb-6 flex gap-4 items-start bg-white border rounded-xl p-4 hover:shadow transition">
      {{-- Thumbnail (klikbaar) --}}
      <a href="{{ route('posts.show', $post) }}" class="w-40 h-28 overflow-hidden rounded border bg-slate-100 flex items-center justify-center shrink-0">
        @if($post->image_path)
          <img src="{{ asset('storage/'.$post->image_path) }}" alt="Afbeelding bij {{ $post->title }}"
               class="w-full h-full object-cover">
        @else
          <span class="text-xs text-slate-500">Geen afbeelding</span>
        @endif
      </a>

      {{-- Content --}}
      <div class="flex-1">
        <h2 class="text-lg font-semibold">
          <a href="{{ route('posts.show', $post) }}" class="hover:underline">
            {{ $post->title }}
          </a>
        </h2>

        <p class="mt-1 text-slate-700">
          {{ \Illuminate\Support\Str::limit($post->body, 180) }}
        </p>

        <p class="mt-1 text-xs text-slate-500">
          {{ $post->created_at->format('d-m-Y H:i') }}
        </p>

        {{-- Acties: lock/unlock + badge --}}
        <div class="mt-2 flex items-center gap-3">
          @can('update', $post)
            <form method="POST" action="{{ route('posts.toggle-lock', $post) }}" class="inline">
              @csrf
              <button class="px-2 py-1 rounded border text-sm">
                {{ $post->locked ? 'Heropenen' : 'Sluiten' }}
              </button>
            </form>
          @endcan

          @if($post->locked)
            <span class="text-xs px-2 py-0.5 rounded bg-slate-200">Gesloten</span>
          @endif
        </div>
      </div>
    </article>
  @empty
    <p>Er zijn nog geen posts.</p>
  @endforelse

  <div class="mt-6">
    {{ $posts->links() }}
  </div>
</x-layout>
