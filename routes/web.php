<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\CompetitionController;

Route::get('/', [CompetitionController::class, 'create']);
Route::post('store', [CompetitionController::class, 'store'])->name('competition.store');
