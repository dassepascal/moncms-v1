<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Volt::route('/', 'users.index');
Route::middleware('guest')->group(function () {
    Volt::route('/register', 'auth.register');
});
