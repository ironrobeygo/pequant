<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\Course\CourseController;

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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::group(['middleware' => 'auth'], function(){

    Route::group(['middleware' => ['role:admin']], function () {

        Route::resource('categories', CategoryController::class, [
            'names' => [
                'index'     => 'categories',
                'create'    => 'categories.add',
                'store'     => 'categories.store',
                'update'    => 'categories.update',
                'delete'    => 'categories.delete'
            ]
        ]);

        Route::resource('institutions', InstitutionController::class, [
            'names' => [
                'index'     => 'institutions',
                'create'    => 'institutions.add',
                'store'     => 'institutions.store',
                'update'    => 'institutions.update',
                'delete'    => 'institutions.delete'
            ]
        ]);

        Route::get('/users/batch', [UserController::class, 'batch'])->name('users.batch');

        Route::resource('users', UserController::class, [
            'names' => [
                'index'     => 'users',
                'create'    => 'users.add',
                'store'     => 'users.store',
                'update'    => 'users.update',
                'delete'    => 'users.delete'
            ]
        ]);

    });
    
    Route::resource('courses', CourseController::class, [
        'names' => [
            'index'     => 'courses',
            'create'    => 'courses.add',
            'store'     => 'courses.store',
            'show'      => 'courses.show',
            'update'    => 'courses.update',
            'delete'    => 'courses.delete'
        ]
    ]);

    Route::resource('courses.chapters', CourseController::class, [
        'names' => [
            'index'     => 'courses.chapters',
            'create'    => 'courses.chapters.add',
            'store'     => 'courses.chapters.store',
            'show'      => 'courses.chapters.show',
            'update'    => 'courses.chapters.update',
            'delete'    => 'courses.chapters.delete'
        ]
    ]);
});