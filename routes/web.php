<?php

use App\Http\Controllers\Auth\LoginFormController;
use App\Http\Controllers\Auth\LoginPostController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Register\RegisterFormController;
use App\Http\Controllers\Register\RegisterPostController;
use App\Http\Controllers\Security\SecurityController;
use App\Http\Controllers\Security\UpdateSecurityController;
use App\Http\Controllers\User\AvatarFormController;
use App\Http\Controllers\User\AvatarUploadController;
use App\Http\Controllers\User\CreateUserFormController;
use App\Http\Controllers\User\CreateUserPostController;
use App\Http\Controllers\User\DeleteUserController;
use App\Http\Controllers\User\EditUserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\Status\StatusController;
use App\Http\Controllers\User\Status\UpdateStatusController;
use App\Http\Controllers\User\UpdateUserController;
use App\Http\Controllers\User\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('register', [RegisterFormController::class, 'create'])->name('register');
Route::post('register', [RegisterPostController::class, 'store'])->name('register.post');

Route::get('login', [LoginFormController::class, 'create'])->name('login');
Route::post('login', [LoginPostController::class, 'store'])
    ->name('login.post')
    ->middleware('throttle:10,1');
Route::post('logout', [LogoutController::class, 'destroy'])->name('logout')
    ->middleware('auth');

Route::redirect('/', '/users');

Route::middleware('auth')->group(function () {
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/users/create', [CreateUserFormController::class, 'create'])->name('users.create');
        Route::post('/users/create', [CreateUserPostController::class, 'store'])->name('users.store');
    });

    Route::get('/users', [UsersController::class, 'index'])->name('users.index');

    Route::get('/users/{user?}/security', [SecurityController::class, 'show'])->name('users.security');
    Route::post('/security', [UpdateSecurityController::class, 'update'])->name('security.update');

    Route::get('/users/{user?}/avatar', [AvatarFormController::class, 'showForm'])->name('upload.avatar.form');
    Route::post('/users/{user?}/avatar', [AvatarUploadController::class, 'upload'])->name('upload.avatar');

    Route::get('/users/{user?}/status', [StatusController::class, 'show'])->name('users.status');
    Route::post('/users/{user}/status', [UpdateStatusController::class, 'update'])->name('update.status');

    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.profile');
    Route::get('/users/{user}/edit', [EditUserController::class, 'show'])->name('users.edit');
    Route::put('/users/{user}', [UpdateUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [DeleteUserController::class, 'destroy'])->name('users.destroy');
});
