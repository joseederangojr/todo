<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\SpaceTaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('signin', Auth\SignInController::class)
            ->name('signin')
            ->middleware('guest');
        Route::post('signup', Auth\SignUpController::class)
            ->name('signup')
            ->middleware('guest');
        Route::post('signout', Auth\SignOutController::class)
            ->name('signout')
            ->middleware('auth');
    });

Route::apiResource('space', SpaceController::class)
    ->middleware('auth')
    ->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('space.task', SpaceTaskController::class)
    ->middleware('auth')
    ->only(['index', 'update', 'store', 'show', 'destroy']);

// Route::post('/space/{space}/task/{task}', [SpaceTaskController::class, 'update'])->name(
//     'space.task.update'
// );
