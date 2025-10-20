<x-layout>
  <h1 class="text-2xl font-bold mb-4">Laatste posts</h1>

  @forelse($posts as $post)
    <a href="{{ route('posts.show', $post) }}" class="block">
      <article class="mb-6 flex gap-4 items-start bg-white border rounded-xl p-4 hover:shadow transition">
        {{-- Thumbnail (links) --}}
        <div class="w-40 h-28 overflow-hidden rounded border bg-slate-100 flex items-center justify-center shrink-0">
          @if($post->image_path)
            <img src="{{ asset('storage/'.$post->image_path) }}" alt="Afbeelding bij {{ $post->title }}"
                 class="w-full h-full object-cover">
          @else
            <span class="text-xs text-slate-500">Geen afbeelding</span>
          @endif
        </div>

        {{-- Content (rechts) --}}
        <div class="flex-1">
          <h2 class="text-lg font-semibold">{{ $post->title }}</h2>
          <p class="mt-1 text-slate-700">
            {{ \Illuminate\Support\Str::limit($post->body, 180) }}
          </p>
          <p class="mt-1 text-xs text-slate-500">
            {{ $post->created_at->format('d-m-Y H:i') }}
          </p>
        </div>
      </article>
    </a>
  @empty
    <p>Er zijn nog geen posts.</p>
  @endforelse

  <div class="mt-6">
    {{ $posts->links() }}
  </div>
</x-layout>
