<?php

use App\Http\Controllers\Frontend\FileUploadController;
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


// routes/file_upload.php

Route::post('/upload-image', [FileUploadController::class, 'fileUpload'])->name('upload.image');