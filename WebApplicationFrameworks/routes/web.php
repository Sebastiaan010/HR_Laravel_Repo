<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


Route::get('/', function () {
    $post = ForumPost::latest()->first();   // pak de meest recente
    return view('home', compact('post'));
});

Route::get('/about', function () {
    return view('about');
});

Route::view('/register', 'register')->name('register');

Route::post('/register', function (Request $req) {
    $data = $req->validate([
        'name' => ['required','string','max:100'],
        'email' => ['required','email','max:255','unique:users,email'],
        'password' => ['required','min:6','confirmed'], // expects password_confirmation
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    return redirect('/')->with('success', 'Account aangemaakt voor '.$user->name);
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

require __DIR__.'/auth.php';
