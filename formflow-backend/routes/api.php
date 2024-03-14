<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\FormsController;

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

/**
 * =========================
 * Login & Registration Routes
 * =========================
 */
Route::post('/login', [UsersController::class, 'login'])
    ->name('api.login');

Route::post('/register', [UsersController::class, 'register'])
    ->name('api.register');

// Authenticated users
Route::middleware('auth:api')->group(function() {

    /**
     * =========================
     * User Routes
     * =========================
     */
    Route::get('/me', [UsersController::class, 'details'])
        ->name('api.me');
    Route::post('/default-project', [UsersController::class, 'updateDefaultProject'])
        ->name('api.default.project');


    /**
     * =========================
     * Project Routes
     * =========================
     */
    Route::get('/projects', [ProjectsController::class, 'index'])
        ->name('api.projects.index');
    Route::post('/projects', [ProjectsController::class, 'create'])
        ->name('api.projects.create');
    Route::delete("/projects/{project}", [ProjectsController::class, 'delete'])
        ->name('api.projects.delete')
        ->middleware('ownership.project');
    Route::get("/projects/{project}", [ProjectsController::class, 'details'])
        ->name('api.projects.details')
        ->middleware('ownership.project');
    Route::put("/projects/{project}", [ProjectsController::class, 'update'])
        ->name('api.projects.update')
        ->middleware('ownership.project');
    Route::get("/projects/{project}/statistics", [ProjectsController::class, 'statistics'])
        ->name('api.projects.statistics')
        ->middleware('ownership.project');

    
    /**
     * =========================
     * Form Routes
     * =========================
     */
    Route::get('/projects/{project}/forms', [FormsController::class, 'index'])
        ->name('api.forms.index')
        ->middleware('ownership.project');
    
    Route::get("/projects/{project}/forms/{form}/submissions", [FormsController::class, 'submissions'])
        ->name('api.forms.submissions')
        ->middleware('ownership.project')
        ->middleware('ownership.form')
        ->middleware('relationship.project-form');

});