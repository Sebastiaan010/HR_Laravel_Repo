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
    </div>
  </div>
</nav>


  <main class="max-w-5xl mx-auto px-4 py-6">
    {{ $slot }}
  </main>
</body>
</html>
