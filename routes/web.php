<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

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
    return view('index');
});
Route::get('/edit', function () {
    return view('edit');
});
Route::get('/history', function () {
    return view('history');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('/project/{id}', 'getProject')->name('project');
    Route::post('/delete/{id}', 'deleteProject')->name('delete');
    Route::get('/', 'index')->name('index');
    Route::post('/', 'create')->name('create');
    Route::get('/edit', 'editView')->name('edit');
    Route::post('/edit', 'editPost')->name('edit.post');
    Route::get('/history', 'historyView')->name('history');

    Route::get('/api/home', 'getDataAjaxHome');
    Route::get('/api/edit', 'getDataAjaxEdit');
    Route::get('/api/history', 'getDataAjaxHistory');
});
