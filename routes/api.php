<?php

use App\Http\Controllers\EconomicGroupController;
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
