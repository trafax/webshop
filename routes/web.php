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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Onderstaand de routes voor de admin
 */

Route::localized(function () {

    Route::prefix('admin')->middleware('role:admin')->group(function () {

        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('language', App\Http\Controllers\Admin\LanguageController::class);
        Route::post('language/search', [App\Http\Controllers\Admin\LanguageController::class, 'index'])->name('language.search');
        Route::post('language/sort', [App\Http\Controllers\Admin\LanguageController::class, 'sort'])->name('language.sort');
        Route::get('language/{language}/set', [App\Http\Controllers\Admin\LanguageController::class, 'setLanguage'])->name('language.set');
        Route::post('language/delete', [App\Http\Controllers\Admin\LanguageController::class, 'delete'])->name('language.delete');

        Route::resource('customer', App\Http\Controllers\Admin\CustomerController::class);
        Route::post('customer/search', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customer.search');
        Route::post('customer/delete', [App\Http\Controllers\Admin\CustomerController::class, 'delete'])->name('customer.delete');

        Route::resource('country', App\Http\Controllers\Admin\CountryController::class);
        Route::post('country/search', [App\Http\Controllers\Admin\CountryController::class, 'index'])->name('country.search');
        Route::post('country/sort', [App\Http\Controllers\Admin\CountryController::class, 'sort'])->name('country.sort');
        Route::post('country/delete', [App\Http\Controllers\Admin\CountryController::class, 'delete'])->name('country.delete');

        Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
        Route::post('category/search', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category.search');
        Route::post('category/sort', [App\Http\Controllers\Admin\CategoryController::class, 'sort'])->name('category.sort');
        Route::post('category/delete', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('category.delete');

        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
        Route::post('product/search', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('product.search');
        Route::post('product/sort', [App\Http\Controllers\Admin\ProductController::class, 'sort'])->name('product.sort');
        Route::post('product/delete', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('product.delete');

        Route::resource('filter', App\Http\Controllers\Admin\FilterController::class);
        Route::post('filter/search', [App\Http\Controllers\Admin\FilterController::class, 'index'])->name('filter.search');
        Route::post('filter/sort', [App\Http\Controllers\Admin\FilterController::class, 'sort'])->name('filter.sort');
        Route::post('filter/delete', [App\Http\Controllers\Admin\FilterController::class, 'delete'])->name('filter.delete');

    });

});
