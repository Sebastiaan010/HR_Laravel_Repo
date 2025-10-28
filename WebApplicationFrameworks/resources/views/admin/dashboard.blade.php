<x-layout>
  <h1 class="text-2xl font-bold mb-6">Admin dashboard</h1>
    
  <section class="mb-10">
    <h2 class="text-lg font-semibold mb-2">Posts</h2>
    <div class="overflow-x-auto border rounded">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-3 py-2 text-left">Titel</th>
            <th class="px-3 py-2 text-left">Auteur</th>
            <th class="px-3 py-2 text-left">Categorie</th>
            <th class="px-3 py-2 text-left">Status</th>
            <th class="px-3 py-2 text-left">Geplaatst</th>
            <th class="px-3 py-2"></th>
          </tr>
        </thead>
        <tbody>
          @forelse($posts as $p)
            <tr class="border-t">
              <td class="px-3 py-2">
                <a href="{{ route('posts.show',$p) }}" class="underline">{{ \Illuminate\Support\Str::limit($p->title,60) }}</a>
              </td>
              <td class="px-3 py-2">{{ $p->user->name ?? 'anoniem' }}</td>
              <td class="px-3 py-2">{{ $p->category ? ucfirst($p->category) : '-' }}</td>
              <td class="px-3 py-2">
                @if($p->locked)
                  <span class="text-xs px-2 py-1 rounded bg-slate-200">Gesloten</span>
                @else
                  <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800">Open</span>
                @endif
              </td>
              <td class="px-3 py-2">{{ $p->created_at->format('d-m-Y H:i') }}</td>
              <td class="px-3 py-2">
                {{-- Lock/unlock (POST naar bestaande controller action) --}}
                <form method="POST" action="{{ route('posts.toggle-lock',$p) }}" class="inline">
                  @csrf
                  <button class="px-2 py-1 border rounded text-xs">
                    {{ $p->locked ? 'Heropenen' : 'Sluiten' }}
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td class="px-3 py-4" colspan="6">Geen posts gevonden.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">{{ $posts->links() }}</div>
  </section>

  <section>
    <h2 class="text-lg font-semibold mb-2">Gebruikers</h2>
    <div class="overflow-x-auto border rounded">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-3 py-2 text-left">Naam</th>
            <th class="px-3 py-2 text-left">Email</th>
            <th class="px-3 py-2 text-left">Rol</th>
            <th class="px-3 py-2 text-left">Aangemaakt</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
            <tr class="border-t">
              <td class="px-3 py-2">{{ $u->name }}</td>
              <td class="px-3 py-2">{{ $u->email }}</td>
              <td class="px-3 py-2">{{ $u->role }}</td>
              <td class="px-3 py-2">{{ $u->created_at->format('d-m-Y H:i') }}</td>
            </tr>
          @empty
            <tr><td class="px-3 py-4" colspan="4">Geen gebruikers gevonden.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">{{ $users->links() }}</div>
  </section>
</x-layout>
