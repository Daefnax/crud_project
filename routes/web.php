<?php

use App\Http\Controllers\Auth\LoginFormController;
use App\Http\Controllers\Auth\LoginPostController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Register\RegisterFormController;
use App\Http\Controllers\Register\RegisterPostController;
use App\Http\Controllers\Security\UpdateSecurityController;
use App\Http\Controllers\Status\StatusController;
use App\Http\Controllers\Status\UpdateStatusController;
use App\Http\Controllers\User\CreateUserFormController;
use App\Http\Controllers\User\CreateUserPostController;
use App\Http\Controllers\User\DeleteUserController;
use App\Http\Controllers\User\EditUserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Security\SecurityController;
use App\Http\Controllers\User\UpdateUserController;
use App\Http\Controllers\User\UploadAvatarController;
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
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');

    Route::get('/profile/{id?}', [ProfileController::class, 'show'])->name('profile');

    Route::get('/status/{id?}', [StatusController::class, 'show'])->name('status');
    Route::post('/update_status', [UpdateStatusController::class, 'update'])->name('update.status');

    Route::get('/security/{id?}', [SecurityController::class, 'show'])->name('security');
    Route::post('/security', [UpdateSecurityController::class, 'update'])->name('security.update');

    Route::get('/upload_avatar{id?}', [UploadAvatarController::class, 'showForm'])->name('upload.avatar.form');
    Route::post('/upload_avatar{id?}', [UploadAvatarController::class, 'upload'])
        ->name('upload.avatar');

    Route::get('/edit_user/{id}', [EditUserController::class, 'show'])->name('edit');
    Route::post('/update_user/{id}', [UpdateUserController::class, 'update'])->name('update');

    Route::delete('/users/{id}', [DeleteUserController::class, 'destroy'])->name('users.destroy');

    Route::middleware(['can:admin'])->group(function () {

        Route::get('/create_user', [CreateUserFormController::class, 'create'])->name('users.create');
        Route::post('/create_user', [CreateUserPostController::class, 'store'])->name('users.store');

    });
});
