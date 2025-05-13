<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/dashboard', 'Dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::inertia('/profile', 'Profile/Edit')->middleware(['auth', 'password.confirm'])->name('profile.edit');

Route::inertia('/', 'Home')->name('home');

require __DIR__.'/auth.php';