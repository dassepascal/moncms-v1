<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Volt::route('/', 'index');
Volt::route('/category/{slug}', 'index');
Route::middleware('guest')->group(function () {
    Volt::route('/login', 'auth.login')->name('login');
    Volt::route('/register', 'auth.register');
    Volt::route('/forgot-password', 'auth.forgot-password');
    Volt::route('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
 
});
