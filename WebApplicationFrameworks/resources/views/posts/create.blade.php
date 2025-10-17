<x-layout>
  <h1 class="text-2xl font-bold mb-4">Nieuwe post</h1>

  @if ($errors->any())
    <ul class="mb-4 text-red-600 text-sm">
      @foreach ($errors->all() as $e) <li>• {{ $e }}</li> @endforeach
    </ul>
  @endif

  <form method="POST" action="{{ route('posts.store') }}" class="max-w-xl space-y-3">
    @csrf
    <div>
      <label class="block text-sm mb-1">Titel</label>
      <input name="title" class="border rounded w-full px-3 py-2" value="{{ old('title') }}">
    </div>
    <div>
      <label class="block text-sm mb-1">Bericht</label>
      <textarea name="body" rows="6" class="border rounded w-full px-3 py-2">{{ old('body') }}</textarea>
    </div>
    <button class="px-4 py-2 rounded bg-blue-600 text-white">Plaatsen</button>
  </form>
</x-layout>
