<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WatchController;

Route::get('/', function () {
    return redirect()->route('watches.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('watches.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('watches', WatchController::class)
        ->except(['edit', 'update'])
        ->middleware(['throttle:20,1']);

    Route::post('watches/{watch}/check', [WatchController::class, 'checkNow'])
        ->middleware('throttle:5,1')
        ->name('watches.check');
});

require __DIR__.'/auth.php';