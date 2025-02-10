<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
   
Route::middleware(['auth', 'verified'])->group(function() {
    
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::view('groups', 'pages.economic-groups.groups')->name('groups');
    Route::view('add-group', 'pages.economic-groups.add-group')->name('add-group');
    Route::view('group/{id}', 'pages.economic-groups.group')->name('group');

    Route::view('flags', 'pages.flags.flags')->name('flags');
    Route::view('add-flag', 'pages.flags.add-flag')->name('add-flag');
    Route::view('flag/{id}', 'pages.flags.flag')->name('flag');

    Route::view('units', 'pages.units.units')->name('units');
    Route::view('add-unit', 'pages.units.add-unit')->name('add-unit');
    Route::view('unit/{id}', 'pages.units.unit')->name('unit');

    Route::view('employees', 'pages.employees.employees')->name('employees');
    Route::view('add-employee', 'pages.employees.add-employee')->name('add-employee');
    Route::view('employee/{id}', 'pages.employees.employee')->name('employee');

    Route::view('reports', 'pages.reports.reports')->name('reports');
    Route::view('add-simple-report', 'pages.reports.add-simple-report')->name('add-simple-report');
    Route::view('add-unit-report', 'pages.reports.add-unit-report')->name('add-unit-report');
    Route::view('add-flag-report', 'pages.reports.add-flag-report')->name('add-flag-report');
    Route::view('add-economic-group-report', 'pages.reports.add-economic-group-report')->name('add-economic-group-report');

    Route::view('audits', 'pages.audits.audits')->name('audits');
    Route::view('audit/{id}', 'pages.audits.audit')->name('audit');
});
    
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
