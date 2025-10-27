<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="utf-8" />
  <title>Home page</title>
  <!-- Tailwind CDN (dev only, super simpel) -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-slate-800">
  <nav class="border-b">
    <div class="max-w-5xl mx-auto px-4 h-12 flex items-center justify-between">
      <div class="flex items-center gap-6">
        <a href="/" class="font-semibold">Home</a>
        <a href="/about">About</a>
        <a href="/contact">Contact</a>
        @auth
          <a href="{{ route('posts.create') }}">Nieuwe post</a>
        @endauth
      </div>

      {{-- Right side: auth --}}
      <div class="flex items-center gap-3">
        @guest
          <a href="{{ route('login') }}">Login</a>
          <a href="{{ route('register') }}">Register</a>
        @endguest

        @auth
          <span class="text-sm text-slate-600">Hi, {{ auth()->user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="underline">Logout</button>
          </form>
        @endauth
        @auth
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Admin</a>
          @endif
        @endauth

      </div>
    </div>
  </nav>

  @if (session('success'))
    <div class="max-w-5xl mx-auto px-4 py-2 text-sm text-green-700 bg-green-50 border border-green-200 rounded mt-3">
      {{ session('success') }}
    </div>
  @endif

  {{-- Simple Pokémon hero (alleen image + subtiele overlay) --}}
  <header class="relative">
    <img src="{{ asset('img/hero.jpg') }}" {{-- zet jouw bestand in public/img/ --}} alt="Pokémon banner"
      class="w-full h-40 sm:h-52 object-cover">
    <div class="absolute inset-0 bg-black/25"></div>
    <div class="absolute inset-0 flex items-center">
      <div class="max-w-5xl mx-auto w-full px-4">
        <h1 class="text-white text-xl sm:text-2xl font-bold drop-shadow">
          PokéForum
        </h1>
        <p class="text-white/90 text-sm drop-shadow">
          Deel je vangsten, decks en tips.
        </p>
      </div>
    </div>
  </header>


  <main class="max-w-5xl mx-auto px-4 py-6">
    {{ $slot }}
  </main>
</body>

<footer class="mt-12 border-t bg-white">
  <div class="max-w-5xl mx-auto px-4 py-6 text-sm text-slate-600
              flex flex-col sm:flex-row items-center justify-between gap-3">
    {{-- mini “pokéball” (pure CSS, geen asset nodig) --}}
    <div class="flex items-center gap-2">
      <span class="relative inline-block w-5 h-5 rounded-full bg-red-600 overflow-hidden">
        <span class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-0.5 bg-black"></span>
        <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2
                      w-2.5 h-2.5 rounded-full bg-white ring-1 ring-black"></span>
      </span>
      <span>© {{ now()->year }} PokéForum</span>
    </div>

    <nav class="flex items-center gap-4">
      <a href="{{ route('home') }}" class="hover:underline">Home</a>
      <a href="{{ route('about') }}" class="hover:underline">About</a>
      <a href="{{ route('contact') }}" class="hover:underline">Contact</a>
      @auth
        <a href="{{ route('posts.create') }}" class="hover:underline">Nieuwe post</a>
      @endauth
    </nav>
  </div>
</footer>


</html>