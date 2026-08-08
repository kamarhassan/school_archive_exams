<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\studentsController;

Route::get('/', [CompetitionController::class, 'create']);
Route::get('competitions', [CompetitionController::class, 'index'])->name('competition.index');
Route::get('competitions/{competition}/files/{type}', [CompetitionController::class, 'viewFile'])->name('competition.file');
Route::post('store', [CompetitionController::class, 'store'])->name('competition.store');



Route::get('students', [studentsController::class, 'index']);
Route::get('students/{student}', [studentsController::class, 'show'])->name('students.show');
Route::put('students/{student}', [studentsController::class, 'update'])->name('students.update');