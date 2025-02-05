<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
   
Route::middleware(['auth', 'verified'])->group(function() {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::view('groups', 'groups')->name('groups');
    Route::view('add-group', 'add-group')->name('add-group');
    Route::view('group/{id}', 'group')->name('group');

    Route::view('flags', 'flags')->name('flags');
});
    
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
