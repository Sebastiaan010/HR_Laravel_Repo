<x-layout>
  <div class="min-h-[60vh] grid place-items-center">
    <div class="w-full max-w-md bg-white border rounded-2xl p-6 shadow-sm">

      <h1 class="text-2xl font-bold mb-1">Log in</h1>
      <p class="text-sm text-slate-600 mb-6">Welkom terug! Log in om verder te gaan.</p>

      @if (session('status'))
        <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded px-3 py-2">
          {{ session('status') }}
        </div>
      @endif

      @if ($errors->any())
        <ul class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded px-3 py-2">
          @foreach ($errors->all() as $e)
            <li>• {{ $e }}</li>
          @endforeach
        </ul>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label for="email" class="block text-sm font-medium">Email</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label for="password" class="block text-sm font-medium">Password</label>
          <input id="password" name="password" type="password" required
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember" class="rounded border-slate-300">
            Remember me
          </label>

          @if (Route::has('password.request'))
            <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
              Forgot your password?
            </a>
          @endif
        </div>

        <button class="w-full rounded-lg bg-blue-600 text-white py-2 font-semibold hover:bg-blue-700 transition">
          Log in
        </button>
      </form>

      <p class="mt-4 text-sm text-center text-slate-600">
        Nieuw hier?
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Maak een account</a>
      </p>
    </div>
  </div>
</x-layout>
