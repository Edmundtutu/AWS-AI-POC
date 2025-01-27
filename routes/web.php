<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\S3Controller;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [S3Controller::class, 'index']);

// File management routes
Route::get('/files', [S3Controller::class, 'index'])->name('files.index');
Route::get('/upload', [S3Controller::class, 'showUploadForm'])->name('upload.show');
Route::post('/upload', [S3Controller::class, 'upload'])->name('upload.store');
Route::get('/download/{filename}', [S3Controller::class, 'download'])->name('download');
Route::delete('/files/{filename}', [S3Controller::class, 'destroy'])->name('files.destroy');

// Chat routes
Route::get('/chat', [ChatController::class, 'show'])->name('chat.show');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send'); 