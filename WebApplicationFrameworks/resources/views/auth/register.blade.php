<x-layout>
  <div class="min-h-[60vh] grid place-items-center">
    <div class="w-full max-w-md bg-white border rounded-2xl p-6 shadow-sm">

      <h1 class="text-2xl font-bold mb-1">Account aanmaken</h1>
      <p class="text-sm text-slate-600 mb-6">Join het forum en plaats je eerste post.</p>

      {{-- Errors --}}
      @if ($errors->any())
        <ul class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded px-3 py-2">
          @foreach ($errors->all() as $e)
            <li>• {{ $e }}</li>
          @endforeach
        </ul>
      @endif

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
          <label for="name" class="block text-sm font-medium">Name</label>
          <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label for="email" class="block text-sm font-medium">Email</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}" required
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label for="password" class="block text-sm font-medium">Password</label>
          <input id="password" name="password" type="password" required
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
          <input id="password_confirmation" name="password_confirmation" type="password" required
                 class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button class="w-full rounded-lg bg-blue-600 text-white py-2 font-semibold hover:bg-blue-700 transition">
          Register
        </button>
      </form>

      <p class="mt-4 text-sm text-center text-slate-600">
        Al een account?
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
      </p>
    </div>
  </div>
</x-layout>
