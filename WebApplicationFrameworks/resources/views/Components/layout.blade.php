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
    <div class="max-w-5xl mx-auto px-4 h-12 flex items-center gap-6">
      <a href="/" class="font-semibold hover:underline">Home</a>
      <a href="/about" class="hover:underline">About</a>
      <a href="/contact" class="hover:underline">Contact</a>
      <a href="/register">Register</a>
    </div>
  </nav>

  <main class="max-w-5xl mx-auto px-4 py-6">
    {{ $slot }}
  </main>
</body>
</html>
