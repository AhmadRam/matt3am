<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\CurrencyExchangeRateController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\CustomerGroupController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RestaurantController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\TableController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:users')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('categories')->group(function () {

        Route::get('/index', [CategoryController::class, 'index']);

        Route::get('/show/{id}', [CategoryController::class, 'show']);

        Route::post('/create', [CategoryController::class, 'create']);

        Route::put('/update/{id}', [CategoryController::class, 'update']);

        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('currencies')->group(function () {

        Route::get('/index', [CurrencyController::class, 'index']);

        Route::get('/show/{id}', [CurrencyController::class, 'show']);

        Route::post('/create', [CurrencyController::class, 'create']);

        Route::put('/update/{id}', [CurrencyController::class, 'update']);

        Route::delete('/destroy/{id}', [CurrencyController::class, 'destroy']);
    });

    Route::prefix('users')->group(function () {

        Route::get('/index', [UserController::class, 'index']);

        Route::get('/show/{id}', [UserController::class, 'show']);

        Route::post('/create', [UserController::class, 'create']);

        Route::put('/update/{id}', [UserController::class, 'update']);

        Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('currency-exchange-rates')->group(function () {

        Route::get('/index', [CurrencyExchangeRateController::class, 'index']);

        Route::get('/show/{id}', [CurrencyExchangeRateController::class, 'show']);

        Route::post('/create', [CurrencyExchangeRateController::class, 'create']);

        Route::put('/update/{id}', [CurrencyExchangeRateController::class, 'update']);

        Route::delete('/destroy/{id}', [CurrencyExchangeRateController::class, 'destroy']);
    });

    Route::prefix('customers')->group(function () {

        Route::get('/index', [CustomerController::class, 'index']);

        Route::get('/show/{id}', [CustomerController::class, 'show']);

        Route::post('/create', [CustomerController::class, 'create']);

        Route::put('/update/{id}', [CustomerController::class, 'update']);

        Route::delete('/destroy/{id}', [CustomerController::class, 'destroy']);
    });

    Route::prefix('customer-groups')->group(function () {

        Route::get('/index', [CustomerGroupController::class, 'index']);

        Route::get('/show/{id}', [CustomerGroupController::class, 'show']);

        Route::post('/create', [CustomerGroupController::class, 'create']);

        Route::put('/update/{id}', [CustomerGroupController::class, 'update']);

        Route::delete('/destroy/{id}', [CustomerGroupController::class, 'destroy']);
    });

    Route::prefix('menus')->group(function () {

        Route::get('/index', [MenuController::class, 'index']);

        Route::get('/show/{id}', [MenuController::class, 'show']);

        Route::post('/create', [MenuController::class, 'create']);

        Route::put('/update/{id}', [MenuController::class, 'update']);

        Route::delete('/destroy/{id}', [MenuController::class, 'destroy']);
    });

    Route::prefix('products')->group(function () {

        Route::get('/index', [ProductController::class, 'index']);

        Route::get('/show/{id}', [ProductController::class, 'show']);

        Route::post('/create', [ProductController::class, 'create']);

        Route::put('/update/{id}', [ProductController::class, 'update']);

        Route::delete('/destroy/{id}', [ProductController::class, 'destroy']);
    });

    Route::prefix('restaurants')->group(function () {

        Route::get('/index', [RestaurantController::class, 'index']);

        Route::get('/show/{id}', [RestaurantController::class, 'show']);

        Route::post('/create', [RestaurantController::class, 'create']);

        Route::put('/update/{id}', [RestaurantController::class, 'update']);

        Route::delete('/destroy/{id}', [RestaurantController::class, 'destroy']);
    });

    Route::prefix('sections')->group(function () {

        Route::get('/index', [SectionController::class, 'index']);

        Route::get('/show/{id}', [SectionController::class, 'show']);

        Route::post('/create', [SectionController::class, 'create']);

        Route::put('/update/{id}', [SectionController::class, 'update']);

        Route::delete('/destroy/{id}', [SectionController::class, 'destroy']);
    });

    Route::prefix('tables')->group(function () {

        Route::get('/index', [TableController::class, 'index']);

        Route::get('/show/{id}', [TableController::class, 'show']);

        Route::post('/create', [TableController::class, 'create']);

        Route::put('/update/{id}', [TableController::class, 'update']);

        Route::delete('/destroy/{id}', [TableController::class, 'destroy']);
    });
});
