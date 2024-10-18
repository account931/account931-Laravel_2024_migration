<?php

use Illuminate\Http\Request;
use App\Http\Api\V1\Controllers\OwnerController;
use App\Models\Owner;
use App\Http\Api\V1\Resources\OwnerResource;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get('/owners', [OwnerController::class, 'index'])->name('api/owners');   //public/api/owners  //same working as below route
//Route::get('/owners', function () { return new OwnerResource(Owner::find(1)); }); //same as above, working

Route::get('/owner/{owner}', [OwnerController::class, 'show'])->name('api/owner');   //public/api/owner/{owner}  //1 owner  //Implicit Route Model Binding

Route::middleware('auth:api')->group(function() {
	//Route::get('/owners', [OwnerController::class, 'index'])->name('api/owners');
});