<x-layout>
  <h1 class="text-2xl font-bold mb-4">Account aanmaken</h1>

  @if ($errors->any())
    <ul class="mb-4 text-red-600 text-sm">
      @foreach ($errors->all() as $e)
        <li>• {{ $e }}</li>
      @endforeach
    </ul>
  @endif

  <form method="POST" action="/register" class="max-w-md space-y-3">
    @csrf
    <div>
      <label class="block text-sm">Naam</label>
      <input name="name" class="border rounded px-3 py-2 w-full" value="{{ old('name') }}">
    </div>

    <div>
      <label class="block text-sm">E-mail</label>
      <input name="email" type="email" class="border rounded px-3 py-2 w-full" value="{{ old('email') }}">
    </div>

    <div>
      <label class="block text-sm">Wachtwoord</label>
      <input name="password" type="password" class="border rounded px-3 py-2 w-full">
    </div>

    <div>
      <label class="block text-sm">Herhaal wachtwoord</label>
      <input name="password_confirmation" type="password" class="border rounded px-3 py-2 w-full">
    </div>

    <button class="border rounded px-4 py-2">Registreren</button>
  </form>
</x-layout>
