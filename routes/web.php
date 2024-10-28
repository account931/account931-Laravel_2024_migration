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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'HomeController@index')->name('home');

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

	//Create new owner
	Route::get('/owner-create', 'Owner\OwnerController@create')->name('owner/create-new');  //create new owner form
	Route::post('/owner/save',   'Owner\OwnerController@save')    ->name('owner/save');  //saving owner form fields via POST
    
	//Edit owner (Implicit Route Model Binding)
	Route::get('/owner-edit/{owner}', 'Owner\OwnerController@edit')   ->name('ownerEdit');  //edit owner form
	Route::put('/owner/update',       'Owner\OwnerController@update') ->name('owner/update');  //updating owner form fields via POST
	
	//Delete owner
	Route::post('/owner-delete', 'Owner\OwnerController@delete')->name('owner/delete-one-owner');  //delete an owner

    //change password
    Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

});