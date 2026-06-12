<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\CompetitionController;

Route::get('/', [CompetitionController::class, 'create']);
Route::get('competitions', [CompetitionController::class, 'index'])->name('competition.index');
Route::get('competitions/{competition}/files/{type}', [CompetitionController::class, 'viewFile'])->name('competition.file');
Route::post('store', [CompetitionController::class, 'store'])->name('competition.store');
