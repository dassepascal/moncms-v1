<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdminOrRedac;

Volt::route('/', 'index');
Volt::route('/category/{slug}', 'index');
Volt::route('/posts/{slug}', 'posts.show')->name('posts.show');
Volt::route('/search/{param}', 'index')->name('posts.search');
Volt::route('/pages/{page:slug}', 'pages.show')->name('pages.show');

Route::middleware('guest')->group(function () {
    Volt::route('/login', 'auth.login')->name('login');
    Volt::route('/register', 'auth.register');
    Volt::route('/forgot-password', 'auth.forgot-password');
    Volt::route('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
   
    
 
});
Route::middleware('auth')->group(function () {
    Volt::route('/profile', 'auth.profile')->name('profile');
    Volt::route('/favorites', 'index')->name('posts.favorites');
    Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
        Volt::route('/dashboard', 'admin.index')->name('admin');
        Volt::route('/posts/index', 'admin.posts.index')->name('posts.index');
        Volt::route('/posts/create', 'admin.posts.create')->name('posts.create');
        Volt::route('/posts/{post:slug}/edit', 'admin.posts.edit')->name('posts.edit');

    });
});
