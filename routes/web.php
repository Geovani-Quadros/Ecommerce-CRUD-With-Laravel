<?php

use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

//Route to page principal (Home)
Route::get('/', [HomeController::class, 'index'])->name('home');

//Route to product page selected
Route::get('/product/{product:slug}', [ProductController::class, "index"])->name('product');



/*
** Admin Routes
*/
//Route to home page on the dashboard
Route::get('/admin/products', [AdminHomeController::class , "index"])->name('admin.home');

//Route to the page to add products in the dashboard
Route::get('/admin/product/addProduct', [AdminHomeController::class , "create"])->name('admin.product.create');
//Route for sending data by POST
Route::post('/admin/product', [AdminHomeController::class , "store"])->name('admin.product.store');

//Route to edit product page
Route::get('/admin/product/{product}/edit', [AdminHomeController::class , "edit"])->name('admin.product.edit');
//Route to method of the edition of product
Route::put('/admin/product/{product}', [AdminHomeController::class , "update"])->name('admin.product.update');

//Route to product exclusion method
Route::delete('/admin/product/{product}', [AdminHomeController::class , "destroy"])->name('admin.product.destroy');

//route to product image delete method
Route::delete('/admin/product/{product}/image', [AdminHomeController::class , "destroyImage"])->name('admin.product.destroyImage');