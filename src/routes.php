<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace ('Mayank\TodoTask\Controllers')->group(function () { 
    Route::prefix('api')->group(function () {        
        Route::get('/categories', 'ApiController@getCategories');
        Route::post('/categories', 'ApiController@addCategories');
        Route::put('/categories/{id}', 'ApiController@updateCategories');
        Route::delete('/categories/{id}', 'ApiController@deleteCategories');
        
        Route::get('/category/{id}/tasks', 'ApiController@getTaskByCategory' );
        Route::post('/category/{id}/tasks', 'ApiController@addTask' );
        Route::put('/category/{categoryId}/tasks/{taskId}', 'ApiController@updateTask' );
        Route::delete('/category/{categoryId}/tasks/{id}', 'ApiController@deleteTask');
    });

});

Route::namespace ('Mayank\TodoTask')->group(function () { 
    Route::get('/todo-task', function () {
        return view('todo/todo');
    })->middleware('web');

});

