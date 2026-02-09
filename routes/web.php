<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Profile
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('profile/{userId}', [App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store');
    Route::patch('profile/{userId}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/{userId}/download-avatar', [App\Http\Controllers\ProfileController::class, 'downloadAvatar'])->name('profile.download-avatar');

    //Reportes
    Route::resource('reportes', App\Http\Controllers\ReporteController::class);

    //Roles
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    //Templates
    Route::resource('templates', App\Http\Controllers\TemplateController::class);

    //Users
    Route::resource('users', App\Http\Controllers\UserController::class);
});
