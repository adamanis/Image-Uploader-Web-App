<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APP\DashboardController;
use App\Http\Controllers\APP\NewImageController;
use App\Events\MessageNotification;

Route::middleware(['auth', 'verified'])->prefix('APP')->name('APP.')->group(function(){
    Route::get('dashboard', [Dashboardcontroller::class, 'show'])->name('dashboard.show');

    Route::get('newimage', [NewImageController::class, 'show'])->name('newimage.show');
    Route::post('newImage', [NewImageController::class, 'store'])->name('newimage.store');
});

require __DIR__.'/auth.php';