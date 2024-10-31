<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Volt::route('/', 'users.index');
Route::middleware('guest')->group(function () {
    Volt::route('/login', 'auth.login')->name('login');
    Volt::route('/register', 'auth.register');
 
});
