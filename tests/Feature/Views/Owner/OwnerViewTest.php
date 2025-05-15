<?php

namespace Tests\Feature\Views\Owner;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Owner;
use App\Models\Venue;
use App\User;
use App\Models\Equipment;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OwnerViewTest extends TestCase
{
	//use DatabaseTransactions; //clear your table after every test
	use RefreshDatabase;  //change
	
	//Route::get('owners', 'Owner\OwnerController@index')->name('/owners');    App\Http\Controllers\Owner\OwnerController
	public function test_owner_index_can_be_rendered(): void
    {
		//$this->withoutExceptionHandling(); 
		
		//have to use this so far, {->forgetCachedPermissions() in setUp()} does not work (???) & tests crash as permissions already exist from other tests (test fail on creating permission with error 'Permission already exists')
        //DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        //DB::table('roles')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('permissions')->truncate();
		
		
		//Create admin role and give him permissions and assign role to some user/users  --------------------------------------
		//$permissionViewOwner    = Permission::create(['name' => 'view owner']);
	    //$permissionViewOwners   = Permission::create(['name' => 'view owners']);
		
		//create web permission 'view owners'
		$permissionViewOwner = Permission::firstOrCreate([  //mega PhpUnit test fix for error 'There is no permission named `view owners` for guard `web`.'
            'name' => 'view owner',
            'guard_name' => 'web'
        ]);
		
		//create web permission 'view owners'
		$permissionViewOwners = Permission::firstOrCreate([  //mega PhpUnit test fix for error 'There is no permission named `view owners` for guard `web`.'
            'name' => 'view owners',
            'guard_name' => 'web'
        ]);
		
		
	   //Create admin role and give him permissions and assign role to some user/users  
		$adminRole = Role::firstOrCreate([  //mega PhpUnit test fix for error 'There is no role named `admin` for guard `web`.'
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
		
	    $adminRole->syncPermissions([
		    $permissionViewOwner,
			$permissionViewOwners  // can add multiple permission to role
		]);
		
		
		

		$user = factory(\App\User::class, 1)->create();  
	    User::first()->assignRole('admin'); //user has no admin role and threfore permission
		
        $this->actingAs(User::first(), 'web'); 
		
		$ownersQuantity = 12;
		$result = factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
			//create hasMany relation (Venues attached to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments attached to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
			});
				
		});
		
		$find = Owner::createdAtLastYear() //createdAtLastYear, confirmed == local scope
            ->with('venues', 'venues.equipments')->get();  //eager loading ['venues' => 'hasMany relation in models\Owner', 'venues.equipments' => 'nested relation in models\Venue, i.e $owner->venues->equipments']
            //->paginate(10);
			
		$response = $this->get('/owners');  // Route you want to test
        $response->assertStatus(200);  // Assert the response is successful
		$response->assertViewIs('owner.index');  // Check if the correct view is returned
		$response->assertViewHas('owners');  //to verify that a specific variable has been passed to a view 
		//$response->assertViewHas('owners', $find); //check that varaible is passed to view and the variable has a specific value:
		$response->assertSee($result->first()->name);
		$response->assertDontSee($result->first()->created_at); // as we dont echo it in blade template
		
		
	}
		
}
