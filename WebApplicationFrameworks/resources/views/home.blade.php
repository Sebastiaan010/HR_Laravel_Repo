<x-layout>
  @if($post)
    <h1 class="text-2xl font-bold">{{ $post->title }}</h1>
    <p class="mt-2 text-slate-700">{{ $post->body }}</p>
    <p class="mt-3 text-xs text-slate-500">Geplaatst: {{ $post->created_at->format('d-m-Y H:i') }}</p>
  @else
    <p>Er is nog geen post.</p>
  @endif
</x-layout>
