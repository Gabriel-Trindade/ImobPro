<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\Agent;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Super;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UsersController;


Auth::routes();

if (!Auth::check()) {
    Route::get('/', [LoginController::class, 'showLoginForm']);
} else {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
}

Route::group(['prefix' => 'auth'], function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('registrar', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
})->middleware([Agent::class, Super::class, Admin::class]);


Route::group(['prefix' => 'companies'], function () {
    Route::get('/', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('create', [CompanyController::class, 'create'])->name('companies.create');
    Route::get('/contact-fields-partial', function (Request $request) {
        $index = $request->get('index', 0);
        return view('companies.partials.contact-fields', compact('index'))->render();
    })->name('contact-fields-partial');
    Route::post('store', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('{id}', [CompanyController::class, 'show'])->name('companies.show');
    Route::get('{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('{id}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UsersController::class, 'index'])->name('users.index');
    // Route::get('create', [UserController::class, 'create'])->name('users.create');
    // Route::post('store', [UserController::class, 'store'])->name('users.store');
    // Route::get('{id}', [UserController::class, 'show'])->name('users.show');
    // Route::get('{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    // Route::put('{id}', [UserController::class, 'update'])->name('users.update');
    // Route::delete('{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
