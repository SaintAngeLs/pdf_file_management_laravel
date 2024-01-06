<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DocumentController;


// Publicly accessible route
Route::get('/article/{hash}', [FileController::class, 'showPdfByHash'])->name('article.view');

Route::middleware(['auth'])->group(function(){

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/documents/{id}/details', [DocumentController::class, 'documentDetails'])->name('document.details');

    Route::get('/documents', [DocumentController::class, 'index'])->name('document');
    Route::get('/document/add', [DocumentController::class, 'documentAdd'])->name('document.add');
    Route::post('/document/add/save', [DocumentController::class, 'documentAddSave'])->name('document.add.save');
    Route::get('/document/{documentId}/edit', [DocumentController::class, 'documentEdit'])->name('document.edit');
    Route::post('/document/edit/save', [DocumentController::class, 'documentUpdateSave'])->name('document.edit.save');
    Route::put('/document/{id}/update-status', [DocumentController::class, 'updateStatus'])->name('document.update.status');
    Route::post('/document/delete', [DocumentController::class, 'documentDelete'])->name('document.delete');
    Route::get('/private/img/{imageName}',  [FileController::class, 'showimage'])->name('img.show');
    Route::get('/private/pdf/{pdfName}', [FileController::class, 'showpdf'])->name('pdf.show');
    Route::get('/check-file-existence', [FileController::class, 'checkFileExistence']);

});


// admin
Route::middleware('admin')->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::get('/user/{user_id}/document', [AdminController::class, 'userDocuments'])->name('user.documents');
});


Auth::routes(['register' => false]);
