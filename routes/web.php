<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    Route::group(['prefix' => 'post'], function () {
    Route::get('index', [PostController::class, 'index'])->name('post.index');
    Route::get('create', [PostController::class, 'create'])->name('post.create');
    Route::post('store', [PostController::class, 'store'])->name('post.store');
    Route::get('update/{slug}', [PostController::class, 'update'])->name('post.update');
    Route::post('edit/{slug}', [PostController::class, 'edit'])->name('post.edit');
    Route::get('delete/{id}', [PostController::class, 'delete'])->name('post.delete');
    Route::delete('destroy/{id}', [PostController::class, 'destroy'])->name('post.destroy');
});

