<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\ReportController;

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/login/post', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register_page'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
Route::get('/homepage_E', [HomeController::class, 'index_E'])->name('homepage.E');
Route::get('/products', [ProductController::class, 'show_product'])->name('products_list');
Route::get('/products_E', [ProductController::class, 'show_product_E'])->name('products_list.E');

Route::get('/', function () {
    return redirect()->route('homepage');
});



Route::middleware(['auth'])->group(function () {

    Route::get('/cart/{cart_id}', [CartController::class, 'index'])->name('cart');
    Route::put('/cart/{cart_id}/quantity/{product_id}', [CartController::class, 'quantity_cart'])->name('cart.quantity');
    Route::delete('/cart/{cart_id}/delete/{product_id}', [CartController::class, 'delete_cart'])->name('cart.remove');
    Route::post('/products/add/{product_id}', [ProductController::class, 'add_to_cart'])->name('add.product');
    
    Route::get('/profile/{user_id}', [ProfileController::class, 'index'])->name('profile_edit');
    Route::put('/profile/{user_id}/edit', [ProfileController::class, 'edit_profile'])->name('profile.edit');
    Route::put('/profile/{user_id}/change_password', [ProfileController::class, 'change_password'])->name('profile.change_password');

    Route::get('/productmanage', [ProductController::class, 'index'])->name('products_manage');
    Route::get('/productmanage/create', [ProductController::class, 'create_product'])->name('products_create');
    Route::post('/productmanage/create/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/productmanage/{product_id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/productmanage/{product_id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/productmanage/delete/{product_id}', [ProductController::class, 'delete'])->name('products.delete');

    Route::get('/productmanage/report/pdf', [ReportController::class, 'generatePDF'])->name('products.pdf');

    Route::get('/usermanage', [ProfileController::class, 'index_manage'])->name('user_manage');
    Route::get('/usermanage/create', [ProfileController::class, 'user_create'])->name('user.create');
    Route::post('/usermanage/create/store', [ProfileController::class, 'user_store'])->name('user.store');

    Route::get('/usermanage/{user_id}', [ProfileController::class, 'user_manage'])->name('user.edit');
    Route::put('/usermanage/{user_id}/update', [ProfileController::class, 'user_update'])->name('user.update');
    Route::delete('/usermanage/{user_id}/delete', [ProfileController::class, 'user_delete'])->name('user.delete');


});
