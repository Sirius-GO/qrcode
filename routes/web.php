<?php

use Illuminate\Support\Facades\Route;

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




Auth::routes();


Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

//QR Code Routes
Route::post('create', [App\Http\Controllers\HomeController::class, 'create'])->name('create.qrcode');
Route::post('edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit.qrcode');
Route::post('delete', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete.qrcode');
