<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\UserController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

Route::get('/admin/logout', [AdminController::class , 'Logout'])->name('admin.logout');

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class , 'UserView'])->name('user.view');
    Route::get('/add', [UserController::class , 'UserAdd'])->name('user.add');
    Route::post('/store', [UserController::class , 'UserStore'])->name('user.store');
    Route::get('/password/edit', [UserController::class , 'passwordView'])->name('user.password');
    Route::put('/password/update/{id}', [UserController::class , 'passwordUpdate'])->name('user.password.update');
    Route::get('/edit/{id}', [UserController::class , 'UserEdit'])->name('user.edit');

    Route::put('/update/{id}', [UserController::class , 'UserUpdate'])->name('user.update');
    Route::delete('/destroy/{id}', [UserController::class , 'UserDelete'])->name('user.destroy');
});


Route::prefix('profile')->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
    Route::get('/', [ProfileController::class , 'show'])->name('profile.view');
    Route::get('/edit', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::put('/update/{id}', [ProfileController::class , 'update'])->name('profile.update');
});