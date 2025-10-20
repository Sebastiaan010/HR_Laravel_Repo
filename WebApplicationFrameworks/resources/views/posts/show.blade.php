<x-layout>
  <article class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
    <p class="mt-2 text-sm text-slate-500">
      Geplaatst {{ $post->created_at->format('d-m-Y H:i') }}
    </p>

    @if($post->image_path)
      <div class="mt-4">
        <img src="{{ asset('storage/'.$post->image_path) }}" alt="Afbeelding bij {{ $post->title }}"
             class="w-full rounded-lg border">
      </div>
    @endif

    <div class="prose max-w-none mt-6">
      {{ $post->body }}
    </div>
  </article>
</x-layout>
