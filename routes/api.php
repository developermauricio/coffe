<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SalesController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*=============================================
     RUTAS PARA LOS PRODUCTOS
   =============================================*/
Route::get('get-products', [ProductController::class, 'getProducts'])->name('api.get.products'); //Lista todos los productos

Route::post('upload-picture', [ProductController::class, 'uploadPicture'])->name('api.upload.product'); //Lista todos los productos
Route::post('create-product', [ProductController::class, 'createProduct'])->name('api.create.product'); //Crear producto
Route::post('editar-product/{productId}', [ProductController::class, 'editProduct'])->name('api.edit.product'); //Editar producto
Route::delete('edit-product/{productId}', [ProductController::class, 'deleteProduct'])->name('api.edit.product'); //Eliminar producto
Route::post('sale-product/{product}/{quantity}', [ProductController::class, 'saleProduct'])->name('api.sale.product'); //Vender producto

/*=============================================
     RUTAS PARA LAS CATEGORÍAS
   =============================================*/
Route::get('get-categories', [CategoryController::class, 'getCategories'])->name('api.get.categories'); //Obtener las categorías del producto

/*=============================================
     RUTAS PARA LAS VENTAS
   =============================================*/
Route::get('get-sales', [SalesController::class, 'getSales'])->name('api.get.sales'); //Lista todas las ventas
