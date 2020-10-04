<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectCheckpointsController;
use App\Http\Controllers\ProjectFormsController;
use App\Http\Controllers\ProjectInvitationsController;
use App\Http\Controllers\ProjectScenariosController;
use App\Http\Controllers\ProjectsController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('projects', ProjectsController::class);

    Route::post('/projects/{project}/scenarios', [ProjectScenariosController::class, 'store']);
    Route::patch('/projects/{project}/scenarios/{scenario}', [ProjectScenariosController::class, 'update']);
    Route::delete('/projects/{project}/scenarios/{scenario}', [ProjectScenariosController::class, 'destroy']);

    Route::post('/projects/{project}/checkpoints', [ProjectCheckpointsController::class, 'store']);
    Route::post('/projects/{project}/forms', [ProjectFormsController::class, 'store']);

    Route::post('/projects/{project}/invitations', [ProjectInvitationsController::class, 'store']);
});

Auth::routes();
