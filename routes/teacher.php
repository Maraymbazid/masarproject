<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\NoteController;
use App\Http\Controllers\teacher\StudentController;
use App\Http\Controllers\Teacher\ExaportImportController;

Route::group(['middleware' => ['auth:teacher']], function () {
    Route::resource('notes', NoteController::class)->except(['destroy']);
    Route::post('/students/get-by-class', [NoteController::class, 'getStudents'])->name('students.getByClass');
    Route::post('/students/get-by-teacher', [StudentController::class, 'getStudentsbyteachers'])->name('students.getStudentsbyteachers');
    Route::get('/students/get-by/teacher', [StudentController::class, 'index'])->name('students.liste');
    Route::get('/teacherDashboard', function () {
        return view('teacher.Dashboard'); // Replace 'example' with your view file name
    });
    Route::get('/export-import-notes-students', [ExaportImportController::class, 'create'])->name('export-import-notes-students');
    Route::post('/notes/export', [ExaportImportController::class, 'export'])->name('notes.export');
    Route::post('/notes/import', [ExaportImportController::class, 'import'])->name('notes.import');
});