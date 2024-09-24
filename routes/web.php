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

Route::get('/home', 'HomeController@index')->name('home');

//Reset password page....

//Auth only
Route::middleware(['web', 'auth'])->group(function (): void {
	
    //Owners list all
    Route::get('owners', 'Owner\OwnerController@index')->name('/owners');
	
	//Owner show one (below 2 possible ways of the same result, 2 different controller methods, one view)
	Route::get('/owner/{id}',    'Owner\OwnerController@showById')->name('ownerOneId');   //Traditional route by id
	Route::get('/owner/{owner}', 'Owner\OwnerController@show')    ->name('ownerOne');     //Implicit Route Model Binding

    //change password
    Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

});