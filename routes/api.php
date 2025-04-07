<?php

use Illuminate\Http\Request;
use App\Http\Api\V1\Controllers\OwnerController;
use App\Models\Owner;
use App\Http\Api\V1\Resources\OwnerResource;
use App\Http\Controllers\Auth_Api\AuthController;
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

//----------------------------- Open routes (do not require Passport( does not require token in request) --------------------------------------

//------ OwnerController API --------
Route::get('/owners',                  [OwnerController::class, 'index'])->name('api/owners');       //public/api/owners  //same working as below route
//Route::get('/owners', function () { return new OwnerResource(Owner::find(1)); }); //same as above, working
Route::get('/owner/{owner}',           [OwnerController::class, 'show'])->name('api/owner/');   //public/api/owner/{owner}  //1 owner  //Implicit Route Model Binding
Route::post('/owner/create',           [OwnerController::class, 'store'])->name('api/owner/create');
Route::put('/owner/update/{owner}',    [OwnerController::class, 'update']); //->name('api/owner/update');  //should be potected too


//User Api Registration/Login
Route::post('/register', [AuthController::class, 'register'])->name('api/register');
Route::post('/login',    [AuthController::class, 'login'])   ->name('api/login');



//----------------------------- Passport Protected routes (requires token)-------------------------------
//protected routes (Passport)
Route::middleware('auth:api')->group(function() {
	
	Route::delete('/owner/delete/{owner}', [OwnerController::class, 'destroy']);
	
	Route::get('/owners/quantity',       [OwnerController::class, 'quantity'])      ->name('api/owners/quantity');        //simply Protected by Passport (without Spatie RBAC), any user who logged via API Login Controller & obtained token, can access it
	Route::get('/owners/quantity/admin', [OwnerController::class, 'quantityAdmin'])->name('api/owners/quantity/admin'); //protected by Passport + Spatie RBAC (user must have permission 'view owner admin quantity')
          //->middleware('permission:view_owner_admin_quantity');
});


//when api route not found
Route::fallback(function (){
    abort(404, 'Sorry, API resource not found');
});