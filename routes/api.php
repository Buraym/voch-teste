<?php

use App\Http\Controllers\EconomicGroupController;
use App\Http\Controllers\FlagController;
use App\Http\Controllers\UnitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("/economic-groups")->group(function() {
    Route::get('/', [EconomicGroupController::class, 'index']);
    Route::get('/search', [EconomicGroupController::class, 'search'])->name("economic-groups.search");
    Route::post('/', [EconomicGroupController::class, 'store'])->name("economic-groups.store");
    Route::get('/{id}', [EconomicGroupController::class, 'show']);
    Route::put('/{id}', [EconomicGroupController::class, 'update'])->name("economic-groups.update");
    Route::delete('/{id}', [EconomicGroupController::class, 'destroy'])->name("economic-groups.destroy");
});

Route::prefix("/flags")->group(function() {
    Route::get('/', [FlagController::class, 'index']);
    Route::get('/search', [FlagController::class, 'search'])->name("flags.search");
    Route::post('/', [FlagController::class, 'store'])->name("flags.store");
    Route::get('/{id}', [FlagController::class, 'show']);
    Route::put('/{id}', [FlagController::class, 'update'])->name("flags.update");
    Route::delete('/{id}', [FlagController::class, 'destroy'])->name("flags.destroy");
});

Route::prefix("/units")->group(function() {
    Route::get('/', [UnitController::class, 'index']);
    Route::get('/search', [UnitController::class, 'search'])->name("units.search");
    Route::post('/', [UnitController::class, 'store'])->name("units.store");
    Route::get('/{id}', [UnitController::class, 'show']);
    Route::put('/{id}', [UnitController::class, 'update'])->name("units.update");
    Route::delete('/{id}', [UnitController::class, 'destroy'])->name("units.destroy");
});
