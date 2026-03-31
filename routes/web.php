<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/test', [HomeController::class, 'test1_page'])->name('test1');
Route::post('/test/show', [HomeController::class, 'test2_page'])->name('test2');



Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/login/post', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register_page'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
Route::get('/products', [ProductController::class, 'show_product'])->name('products_list');

Route::get('/', function () {
    return redirect()->route('homepage');
});

Route::get('/profile/{user_id}', [ProfileController::class, 'index'])->name('profile_edit');

Route::get('/productmanage', [ProductController::class, 'index'])->name('products_manage');

Route::get('/productmanage/report/pdf', [ReportController::class, 'generatePDF'])->name('products.pdf');

Route::get('/usermanage', [ProfileController::class, 'index_manage'])->name('user_manage');

