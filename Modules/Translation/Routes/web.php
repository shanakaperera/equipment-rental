<?php

use Illuminate\Support\Facades\Route;
use Modules\Translation\Http\Controllers\TranslationController;
use Modules\Translation\Http\Controllers\TranslationLanguageController;

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

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Translation Languages Routes
    Route::prefix('translation-languages')->group(function () {
        Route::get('/', [TranslationLanguageController::class, 'index'])->name('translation-languages.index');
        Route::post('/', [TranslationLanguageController::class, 'store'])->name('translation-languages.store');
    });

    // Translations Routes
    Route::prefix('translations/{lang}')->group(function () {
        Route::get('/', [TranslationController::class, 'index'])->name('translations.index');
        Route::post('/', [TranslationController::class, 'store'])->name('translations.store');
    });

});
