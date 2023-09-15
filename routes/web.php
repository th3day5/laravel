<?php

use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

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

Route::get('/fill/{token}', [FormController::class, 'showForm']);
Route::put('/submitForm/{token}', [FormController::class, 'submitForm']);
Route::get('/download/{token}', [FormController::class, 'downloadPdf']);

Route::get('/form', [FormController::class, 'generatePdf']);
Route::post('/generate-pdf', [FormController::class, 'fillPDFFile'])->name('generate-pdf');

Route::get('/preview/{token}', [FormController::class, 'previewPdf'])->name('preview-pdf');
