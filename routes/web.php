<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectCheckpointsController;
use App\Http\Controllers\ProjectFormsController;
use App\Http\Controllers\ProjectInvitationsController;
use App\Http\Controllers\ProjectPinsController;
use App\Http\Controllers\ProjectScenariosController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UserSearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/verify', function () {
    return ['message' => 'Please verify your email address'];
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('projects', ProjectsController::class);

    Route::post('/projects/{project}/scenarios', [ProjectScenariosController::class, 'store']);
    Route::patch('/projects/{project}/scenarios/{scenario}', [ProjectScenariosController::class, 'update']);
    Route::delete('/projects/{project}/scenarios/{scenario}', [ProjectScenariosController::class, 'destroy']);

    Route::get('/projects/{project}/checkpoints', [ProjectCheckpointsController::class, 'index']);
    Route::post('/projects/{project}/checkpoints', [ProjectCheckpointsController::class, 'store']);
    Route::post('/projects/{project}/forms', [ProjectFormsController::class, 'store']);
    Route::patch('/projects/{project}/forms/{form}', [ProjectFormsController::class, 'update']);
    Route::post('/projects/{project}/pins', [ProjectPinsController::class, 'store']);
    Route::delete('/projects/{project}/pins', [ProjectPinsController::class, 'destroy']);

    Route::post('/projects/{project}/invitations', [ProjectInvitationsController::class, 'store']);
    Route::get('/users', [UserSearchController::class, 'show']);
});

Auth::routes();
