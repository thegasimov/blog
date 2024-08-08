<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/',[\App\Http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');
    Route::resource('/blogs', \App\Http\Controllers\Admin\BlogController::class);
    Route::resource('/blogs/category', \App\Http\Controllers\Admin\BlogCategoryController::class);





    Route::post('/image-upload',[\App\Http\Controllers\Admin\FileManagerController::class,'imageUpload'])->name('image.upload');
    Route::post('/delete-image', [\App\Http\Controllers\Admin\FileManagerController::class, 'deleteImage'])->name('image.delete');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
