<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->group(function () {
    Route::view('/posts/create', 'posts.create')->name('posts.create');

    Route::post('/posts', function (Request $req) {
        $data = $req->validate([
            'title' => ['required', 'string', 'max:200'],
            'body' => ['required', 'string'],
        ]);

        ForumPost::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'user_id' => Auth::id(),
        ]);

        return redirect('/')->with('success', 'Post geplaatst!');
    })->name('posts.store');
});


Route::get('/', function () {
    $posts = ForumPost::latest()->paginate(15); // max 15 per pagina
    return view('home', compact('posts'));
});


Route::get('/about', function () {
    return view('about');
});

Route::view('/register', 'register')->name('register');

Route::post('/register', function (Request $req) {
    $data = $req->validate([
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'min:6', 'confirmed'], // expects password_confirmation
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    return redirect('/')->with('success', 'Account aangemaakt voor ' . $user->name);
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
