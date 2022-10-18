<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\SettingController;

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

    // Settings Routes
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index')->middleware(['permission:view-system-variable']);
        Route::post('/', [SettingController::class, 'store'])->name('settings.store')
            ->middleware(['permission:create-system-variable|update-system-variable|delete-system-variable']);
    });
});
