<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Supervisor\NoteController;
use App\Http\Controllers\Supervisor\StudentController;

Route::group(
    ['middleware' => ['auth:supervisor']],
    function () {
        Route::resource('students', StudentController::class)->except(['destroy']);

        Route::post('/import-students', [StudentController::class, 'import'])->name('students.import');

        Route::get('/download-file', [StudentController::class, 'downloadfile'])->name('downloadfile');
        Route::get('/download-page', [StudentController::class, 'downloadpage'])->name('download.page');
        Route::get('students/export/{format}', [StudentController::class, 'export'])->name('students.export');
        Route::get('students/{id}/delete', [StudentController::class, 'destroy'])->name('students.delete');
        Route::get('select-class-by-supervisor', [StudentController::class, 'index1'])->name('select-class-by-supervisor');


        Route::post('/deleteall/students', [StudentController::class, 'deleteall'])->name('students.deleteall');
        Route::get('editstudents', [StudentController::class, 'editstudents'])->name('editstudents');
        Route::post('update-selected-students', [StudentController::class, 'updateSelectedStudents'])->name('updateSelectedStudents');
        Route::post('add-one-student', [StudentController::class, 'addonestudent'])->name('addonestudent');
        Route::get('add-one-student', [StudentController::class, 'createonestudent'])->name('add-one-student');
        Route::view('/test', 'test');
        Route::get('get-note-by-supervisor', [NoteController::class, 'create'])->name('get-note-by-supervisor');
        Route::post('get-note-by-supervisor', [NoteController::class, 'index'])->name('get-note-by-supervisors');
        Route::get('/get-exams-by-subject-id', [NoteController::class, 'getExamsBySubjectId'])->name('getExamsBySubjectId');
        Route::post('store-note-by-supervisor', [NoteController::class, 'store'])->name('store-note-by-supervisors');
    }
);
