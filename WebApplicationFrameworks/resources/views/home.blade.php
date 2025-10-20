<x-layout>
  <h1 class="text-2xl font-bold mb-4">Laatste posts</h1>

  @forelse($posts as $post)
    <article class="mb-6">
      <h2 class="text-xl font-semibold">
        {{ $post->title }}
      </h2>
      <p class="mt-1">
        {{ \Illuminate\Support\Str::limit($post->body, 160) }}
      </p>
      <p class="mt-1 text-xs text-slate-500">
        {{ $post->created_at->format('d-m-Y H:i') }}
      </p>
    </article>
  @empty
    <p>Er zijn nog geen posts.</p>
  @endforelse

  {{-- paginatie-links --}}
  <div class="mt-6">
    {{ $posts->links() }}
  </div>
</x-layout>
