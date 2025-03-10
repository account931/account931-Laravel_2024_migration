<?php

use Illuminate\Http\Request;
use App\Http\Api\V1\Controllers\OwnerController;
use App\Models\Owner;
use App\Http\Api\V1\Resources\OwnerResource;
use App\Http\Controllers\API\AuthController;
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

//----------------------------- Open routes --------------------------------------
Route::get('/owners', [OwnerController::class, 'index'])->name('api/owners');       //public/api/owners  //same working as below route
//Route::get('/owners', function () { return new OwnerResource(Owner::find(1)); }); //same as above, working

Route::get('/owner/{owner}', [OwnerController::class, 'show'])->name('api/owner/');   //public/api/owner/{owner}  //1 owner  //Implicit Route Model Binding

//User Api Registration
Route::post('/register', [AuthController::class, 'register'])->name('api/register');


//----------------------------- Protected routes -------------------------------
//protected routes (Passport)
Route::middleware('auth:api')->group(function() {
	Route::get('/owners/quantity', [OwnerController::class, 'quantity'])->name('api/owners/quantity');
});


//when api route not found
Route::fallback(function (){
    abort(404, 'Sorry, API resource not found');
});