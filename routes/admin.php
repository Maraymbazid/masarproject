<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\TeatcherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['auth:admin']], function () {
    Route::resource('subjects', SubjectController::class)->except(['destroy']);
    Route::get('subjects/{subject}/delete', [SubjectController::class, 'destroy'])->name('subjects.delete');
    Route::resource('teatchers', TeatcherController::class)->except(['destroy']);
    Route::get('teatchers/{teatcher}/delete', [TeatcherController::class, 'destroy'])->name('teatchers.delete');
    Route::get('teatchers/{teatcher}/show', [TeatcherController::class, 'show'])->name('teatchers.show');
    Route::resource('classes', ClassController::class)->except(['destroy']);
    Route::get('classes/{class}/delete', [ClassController::class, 'destroy'])->name('classes.delete');
    Route::resource('supervisors', SupervisorController::class)->except(['destroy']);
    Route::get('supervisors/{supervisor}/delete', [SupervisorController::class, 'destroy'])->name('supervisors.delete');
    Route::get('supervisors/{supervisors}/show', [SupervisorController::class, 'show'])->name('supervisors.show');
    Route::resource('exams', ExamController::class)->except(['destroy']);
    Route::get('exams/{exam}/delete', [ExamController::class, 'destroy'])->name('exams.delete');
});
