<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\User\Http\Controllers\LoginController;
use Modules\User\Http\Controllers\PermissionController;
use Modules\User\Http\Controllers\ProfileController;
use Modules\User\Http\Controllers\RoleController;
use Modules\User\Http\Controllers\UserController;

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

//Route::prefix('user')->group(function() {
//    Route::get('/', 'UserController@index');
//});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('login', [LoginController::class, 'login'])->name('login.store');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Permissions Routes
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index')
            ->middleware(['permission:view-permission']);
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store')
            ->middleware(['permission:create-permission|update-permission|delete-permission']);
    });

    // Roles Routes
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index')->middleware(['permission:view-user-role']);
        Route::post('/', [RoleController::class, 'store'])->name('roles.store')
            ->middleware(['permission:create-user-role|update-user-role|delete-user-role']);
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware(['permission:update-user-role']);
    });

    // Users Routes
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware(['permission:view-user']);
        Route::post('/', [UserController::class, 'store'])->name('users.store')
            ->middleware(['permission:create-user|update-user|delete-user']);
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware(['permission:update-user']);
    });
});
