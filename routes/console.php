<?php

use Illuminate\Foundation\Inspiring;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

//My phone quiz test to console
Artisan::command('quiz:start', function () {
	$a = '1112031584';
	$s = '';
		
	for ($i = 1; $i < strlen($a); $i++){
			
		if($a[$i] % 2 == $a[$i -1]){
			$s.= max($a[$i], $a[$i -1]);
		} 
	}
	dd("phone is " . $s);
    //$this->info("Sending email to: !");
});

//test event/listener, it creates a 1 owner & the listener will deleted the created owner at once. Listener fires in console only (defined in Listener)
// Deletion is defined in Models\Owner => $dispatchesEvents = [event/listener
//Event is bound to Listener in Providers\EventServiceProvider
//Triger it with 'php artisan event-listener:start'
Artisan::command('event-listener:start', function () {
	$owner = new \App\Models\Owner();
	$owner->first_name = 'Some';
	$owner->last_name = 'Some 2';
	$owner->email = 'some@gmail.com';
	$owner->phone = '343434';
	$owner->location = 'UK';
	$owner->save();
	
	//$owner->forceDelete();  //moved to Listener  App\Listeners\SendOwnerCreatedNotification
});


//Start Spatie Laravel permission -----


//Spatie Laravel permission => check user role/permission, call => php artisan spatie-permission:checkUser
Artisan::command('spatie-permission:checkUser', function () {
	
	//Get all certain role permission
	$role = Role::findByName('admin');
	//dd($role->permissions->pluck('name'));
	
	// get a list of all roles assigned to the user
	$roleNames = User::find(1)->getRoleNames(); //  all Roles 
	dd($roleNames);
	
	// get a list of all permissions assigned to the user
    //$permissionNames = auth()->user()->getPermissionNames(); // collection of name strings
	$permissionNames = User::find(1)->getAllPermissions()->pluck('name'); //  all Permissions   ($user->getDirectPermissions(), $user->getAllPermissions();)
	//dd($permissionNames);
	
	//check if user has permission
	$checkPermission = User::find(1)->can('view owners');
	//dd($checkPermission);
	
	//check if user has role
	$checkRole = User::find(1)->hasRole('admin');
	//dd($checkRole);
});


//Spatie Laravel permission => manually create role, permission and assign it to user. DO NOT USE IT (unless for some testing), as it is now in RolesPermissionSeeder
Artisan::command('spatie-permission:createRolePermissions', function () {
	
	if (count(Role::findByName('admin')->get()) <= 0 ) {
	    $role = Role::create(['name' => 'admin']);
	}
	
	$permissionViewOwner    = Permission::create(['name' => 'view owner']);
	$permissionViewOwners   = Permission::create(['name' => 'view owners']);
    $permissionEditOwner    = Permission::create(['name' => 'edit owners']);
	$permissionDeleteOwner  = Permission::create(['name' => 'delete owners']);
	
	$permissionNotForAdmin  = Permission::create(['name' => 'not admin permission']);
	
	//$role->givePermissionTo($permission);
	$role = Role::findByName('admin');
	$role->syncPermissions([$permissionViewOwner, $permissionViewOwners, $permissionEditOwner, $permissionDeleteOwner]);  //multiple permission to role

	User::find(1)->assignRole('admin');
});
//End  Spatie Laravel permission -----




//test Api Controller registration => App\Http\Controllers\API\AuthController; call => php artisan testApi -------------------------------------
//was waorking, if fails, make sure to have Passport Personal access client in local DB. Generate by  { php artisan passport:client --personal }
Artisan::command('testRegistrationViaApiAuth', function () {
	$client = new Client();
	try {
    
		$response = $client->post('http://localhost/Laravel_2024_migration/public/api/register', [
		    'http_errors' => false,     //to get response in json, not html
			'headers'     => ['Accept' => 'application/json'],
            'json'        => ['name' => 'dimmmnn', 'email' => 'dsd@gmail.com', 'password' => 'somepassword', 'password_confirmation' => 'somepassword'] 
        ]);
	 
	 
	} catch (ClientException $e) {
		// An exception was raised but there is an HTTP response body
        // with the exception (in case of 404 and similar errors)
        $response = $e->getResponse(); //dd($response);
        $responseBodyAsString = $response->getBody()->getContents();
        //echo $response->getStatusCode() . PHP_EOL;
        //echo $responseBodyAsString;
    }

    dd($response->getBody()->getContents());
    //$responseJSON = json_decode($response->getBody(), true);
	//dd($responseJSON);
	});
	
	
	
	//call => php artisan manuallyGeneratePassportToken --------------------------------------------------------------------------
	Artisan::command('manuallyGeneratePassportToken', function () {
		$user = User::find(1);
        $token = $user->createToken('UserToken', ['*'])->accessToken;
		//$token  = $user->token();
		dd($token);
	});
	
	
	//test Passport
	//to test calling protected api endpoint (by Passport) (works), should allow only auth users ------------------------------------
	Artisan::command('test_api_route_protected_by_Passport', function () {
		$client = new Client();
		$user = User::find(1);
        $bearerToken = $user->createToken('UserToken', ['*'])->accessToken;
		
		//$response = $client->get('http://localhost/Laravel_2024_migration/public/api/owners/quantity?access_token=' . $bearerToken); //Does not work
		
		$response = $client->request('GET', 'http://localhost/Laravel_2024_migration/public/api/owners/quantity',   //this works
            [ 'headers' => [ 
			    'Accept'        => 'application/json',
			    'Authorization' => 'Bearer ' . $bearerToken 
			] ]
        ); 
		
        dd($response->getBody()->getContents());
	});
	
	
	//test Passport +  Spatie RBAC permssion 'view owner admin quantity'. Woks fine, if fail: make sure on prod, migrate:fresh, db:seed
	//to test calling protected api endpoint (by Passport) (works), should allow only auth users + user having Spatie RBAC permssion 'view owner admin quantity' ------------------------------------
	Artisan::command('test_api_route_protected_by_Passport_and_Spatie', function () {
		$client = new Client();
		$user = User::find(1); //user 1 has permission, user 2 does not have (set in Seeders)
		//dd($user->getAllPermissions()->pluck('name'));
        $bearerToken = $user->createToken('UserToken', ['*'])->accessToken;
		
		//$response = $client->get('http://localhost/Laravel_2024_migration/public/api/owners/quantity?access_token=' . $bearerToken); //Does not work
		
		$response = $client->request('GET', 'http://localhost/Laravel_2024_migration/public/api/owners/quantity/admin', [  //this works
            'headers' => [ 'Authorization' => 'Bearer ' . $bearerToken ]
        ]); 
		
        dd($response->getBody()->getContents());
	});