<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BerichtStatusController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Models\ForumPost;
use App\Models\Comment;

/**
 * Home: laatste posts (max 15 per pagina) + zoeken & filter
 */
Route::get('/', function (Request $req) {
    $categories = ['algemeen', 'ruil', 'deck', 'waarde']; 

    $posts = ForumPost::with('user')
        ->when($req->q, function ($q) use ($req) {
            $q->where(function ($sub) use ($req) {
                $sub->where('title', 'like', '%' . $req->q . '%')
                    ->orWhere('body', 'like', '%' . $req->q . '%');
            });
        })
        ->when($req->category, fn($q) => $q->where('category', $req->category))
        ->latest()
        ->paginate(15)
        ->withQueryString();

    return view('home', compact('posts', 'categories'));
})->name('home');

/**
 * Statische pagina’s
 */
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

/**
 * Dashboard (doorverwijzen naar home)
 */
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

/**
 * Profiel (Breeze)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Posts & Comments – alleen voor ingelogde users
 */
Route::middleware('auth')->group(function () {
    // Create
    Route::get('/posts/create', function () {
        $count = Comment::where('user_id', auth()->id())->count();
        if ($count < 5) {
            return redirect()->route('home')
                ->with('success', 'Je hebt minimaal 5 reacties nodig om een topic te openen.');
        }
        return view('posts.create');
    })->name('posts.create');

    Route::post('/posts', function (Request $req) {
        $data = $req->validate([
            'title' => ['required', 'string', 'max:200'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,gif', 'max:2048'],
            'category' => ['nullable', 'string', 'max:50'],
        ]);

        $imagePath = $req->hasFile('image')
            ? $req->file('image')->store('posts', 'public')
            : null;

        ForumPost::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'category' => $data['category'] ?? null,
            'image_path' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')->with('success', 'Post geplaatst!');
    })->name('posts.store');

    // Edit
    Route::get('/posts/{post}/edit', function (ForumPost $post) {
        Gate::authorize('update', $post);
        return view('posts.edit', compact('post'));
    })->name('posts.edit')->whereNumber('post');

    // Update
    Route::put('/posts/{post}', function (Request $req, ForumPost $post) {
        Gate::authorize('update', $post);

        $data = $req->validate([
            'title' => ['required', 'string', 'max:200'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,gif', 'max:2048'],
            'category' => ['nullable', 'string', 'max:50'],
        ]);

        if ($req->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $post->image_path = $req->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $data['title'],
            'body' => $data['body'],
            'category' => $data['category'] ?? null,  
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Post bijgewerkt');
    })->name('posts.update')->whereNumber('post');

    // Delete
    Route::delete('/posts/{post}', function (ForumPost $post) {
        Gate::authorize('delete', $post);
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();
        return redirect()->route('home')->with('success', 'Post verwijderd');
    })->name('posts.destroy')->whereNumber('post');

    // Status toggle (LOCK/UNLOCK) — POST naar aparte controller action
    Route::post('/posts/{post}/toggle-lock', [BerichtStatusController::class, 'toggle'])
        ->name('posts.toggle-lock')
        ->whereNumber('post');

    // Comments: aanmaken (blokkeren als gesloten)
    Route::post('/posts/{post}/comments', function (Request $req, ForumPost $post) {
        if ($post->locked) {
            abort(403, 'Dit topic is gesloten.');
        }

        $data = $req->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        Comment::create([
            'forum_post_id' => $post->id,
            'user_id' => auth()->id(),
            'body' => $data['body'],
        ]);

        return back()->with('success', 'Reactie geplaatst!');
    })->name('comments.store')->whereNumber('post');

    Route::delete('/comments/{comment}', function (Comment $comment) {
        $user = auth()->user();
        if (!$user || ($comment->user_id !== $user->id && $user->role !== 'admin')) {
            abort(403);
        }
        $comment->delete();
        return back()->with('success', 'Reactie verwijderd');
    })->name('comments.destroy')->whereNumber('comment');

    Route::get('/admin', function () {
    $user = auth()->user();
    if (!$user || $user->role !== 'admin') abort(403);

    $posts = ForumPost::with('user')->latest()->paginate(20);
    $users = \App\Models\User::latest()->paginate(20);

    return view('admin.dashboard', compact('posts','users'));
})->name('admin.dashboard');


});

/**
 * Post detail (toon post + comments)
 * LET OP: deze staat NA alle vaste /posts/... routes
 */
Route::get('/posts/{post}', function (ForumPost $post) {
    $post->load(['user', 'comments.user']);
    return view('posts.show', compact('post'));
})->name('posts.show')->whereNumber('post');

/**
 * Breeze auth routes (login, register, etc.)
 */
require __DIR__ . '/auth.php';
