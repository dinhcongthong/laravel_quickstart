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
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/verify-account/{verify_code?}', [App\Http\Controllers\Auth\RegisterController::class, 'verify'])->name('register_verify');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test-dtb', [App\Http\Controllers\HomeController::class, 'testDatatable'])->name('test_dtb');

Auth::routes();

// admin pages
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.users');
    });
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'index'])->name('users');
    Route::get('/users-datatables', [App\Http\Controllers\AdminController::class, 'getUser'])->name('users_datatable');
});

// Route::controller('datatables', [App\Http\Controllers\AdminController::class], [
//     'anyData'  => 'datatables.data',
//     'getIndex' => 'datatables',
// ]);

