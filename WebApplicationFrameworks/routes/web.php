<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ForumPost;

/**
 * Home: laatste posts (max 15 per pagina)
 */
Route::get('/', function () {
    $posts = ForumPost::latest()->paginate(15);
    return view('home', compact('posts'));
})->name('home');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

/** 
 * Posts (aanmaken) – alleen voor ingelogde users
 */
Route::middleware('auth')->group(function () {
    Route::view('/posts/create', 'posts.create')->name('posts.create');

    Route::post('/posts', function (Request $req) {
        $data = $req->validate([
            'title' => ['required', 'string', 'max:200'],
            'body'  => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp,gif', 'max:2048'], 
        ]);

        $imagePath = null;
        if ($req->hasFile('image')) {
            // Slaat op in storage/app/public/posts bereikbaar via /storage 
            $imagePath = $req->file('image')->store('posts', 'public');
        }

        ForumPost::create([
            'title'      => $data['title'],
            'body'       => $data['body'],
            'image_path' => $imagePath,
            'user_id'    => Auth::id(),
        ]);

        return redirect()->route('home')->with('success', 'Post geplaatst!');
    })->name('posts.store');
});

Route::get('/posts/{post}', function (ForumPost $post) {
    return view('posts.show', compact('post'));
})->name('posts.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
