<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
   
Route::middleware(['auth', 'verified'])->group(function() {
    
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::view('groups', 'groups')->name('groups');
    Route::view('add-group', 'add-group')->name('add-group');
    Route::view('group/{id}', 'group')->name('group');

    Route::view('flags', 'flags')->name('flags');
    Route::view('add-flag', 'add-flag')->name('add-flag');
    Route::view('flag/{id}', 'flag')->name('flag');

    Route::view('units', 'units')->name('units');
    Route::view('add-unit', 'add-unit')->name('add-unit');
    Route::view('unit/{id}', 'unit')->name('unit');

    Route::view('employees', 'employees')->name('employees');
    Route::view('add-employee', 'add-employee')->name('add-employee');
    Route::view('employee/{id}', 'employee')->name('employee');

    Route::view('reports', 'reports')->name('reports');
    Route::view('add-simple-report', 'add-simple-report')->name('add-simple-report');
    Route::view('add-unit-report', 'add-unit-report')->name('add-unit-report');
    Route::view('add-flag-report', 'add-flag-report')->name('add-flag-report');
    Route::view('add-economic-group-report', 'add-economic-group-report')->name('add-economic-group-report');

    Route::view('audits', 'audits')->name('audits');
    Route::view('audit/{id}', 'audit')->name('audit');
});
    
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
