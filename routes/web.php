<?php

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

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::resource('tasks', 'TaskController', [
        'only' => [
            'index', 'store', 'update'
        ]
    ]);

});
Route::middleware(['auth','auth.admin'])->group(function() {
    Route::resource('edits', 'TaskController', [
        'only' => [
            'edit','destroy'
        ]
    ]);

});
Route::get('/admin',function(){
    return 'admin yes';
})->middleware(['auth','auth.admin']);



Route::namespace('Admin')->prefix('admin')->middleware(['auth','auth.admin'])->name('admin.')->group(function(){
    Route::resource('/users','UserController',['except' => ['show', 'create', 'store']]);
    Route::resource('/tasks','UserController',['except' => ['show', 'create', 'store']]);
});
