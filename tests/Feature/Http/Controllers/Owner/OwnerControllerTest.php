<?php

/*
Tests for 
Validation:
Required fields (first_name, last_name)
Redirect and session flash message

A new owner is created.
The venues are attached correctly.
It redirects successfully with the expected flash message
*/
namespace Tests\Feature\Http\Controllers\Owner;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Owner;
use App\Models\Venue;
use App\User;
use App\Models\Equipment;
use Illuminate\Testing\Fluent\AssertableJson;
//use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test
use Illuminate\Foundation\Testing\RefreshDatabase;       //trait to clear your table after every test
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Testing\Fluent\AssertableJson; //in Laravel < 6 only
use App\Notifications\SendMyNotification;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class OwnerControllerTest extends TestCase
{
	use RefreshDatabase; //clear your table after every test
	
	protected function setUp(): void   // optional, initialize any necessary dependencies or objects
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now unset/ de-register all the roles and permissions by clearing the permission cache
        //$this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
	
	
   /** @test index, 
    * access requires Spatie permission  'view owners' 
	*
	*/
    public function testIndex()
    {
        // now unset/ de-register all the roles and permissions by clearing the permission cache
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();	
		
		//$this->withoutExceptionHandling(); //to see errors
		
		$ownersQuantity = 12;
		
		//create owners, venues, equipments
		$result = factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
			//create hasMany relation (Venues attached to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments attached to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
			});
				
		});
			
		
		//create web permission 'view owners'
		$permissionViewOwners = Permission::firstOrCreate([  //mega PhpUnit test fix for error 'There is no permission named `view owners` for guard `web`.'
            'name' => 'view owners',
            'guard_name' => 'web'
        ]);

		/*
        if (!$permissionViewOwners) { 
            $permissionViewOwners = Permission::firstOrCreate([
                'name' => 'view owners',
                'guard_name' => 'web'
            ]);
        } 
		*/
		//end create web permission 'view owners'
		
		
		//Create admin role and give him permissions and assign role to some user/users  
		$adminRole = Role::firstOrCreate([  //mega PhpUnit test fix for error 'There is no role named `admin` for guard `web`.'
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
		
	    $adminRole->syncPermissions([
			$permissionViewOwners  // can add multiple permission to role
		]); 
		//end Create admin role and give him permissions and assign role to some user/users 
		
		$user = factory(\App\User::class)->create();
		
		User::first()->assignRole('admin');
		
        $this->actingAs(User::first());



        // Bypass policy or mock it. Policies use Gate under the hood
        Gate::shouldReceive('authorize')
            ->with('index', \App\Models\Owner::class)
            ->andReturn(true);
			

        // Act: call the route
        $response = $this->get(route('/owners'));

        // Assert: correct view and data
        $response->assertStatus(200);
        $response->assertViewIs('owner.index');
        $response->assertViewHasAll([
            'name',
            'owners',
        ]);
    }
	
	
	
   /** @test show one, route('ownerOneId',   ['id' => $result->first()->id])) 
    * access requires Spatie permission  'view owners' 
	*
	*/
    public function testShow()
    {
		 
		// now unset/ de-register all the roles and permissions by clearing the permission cache
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
		//$this->withoutExceptionHandling(); //to see errors
		
		$ownersQuantity = 12;
		
		//create owners, venues, equipments
		$result = factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
			//create hasMany relation (Venues attached to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments attached to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
			});
				
		});
		
		//create web permission 'view owner'
		$permissionViewOwner = Permission::firstOrCreate([  //mega PhpUnit test fix for error 'There is no permission named `view owner` for guard `web`.'
            'name' => 'view owner',
            'guard_name' => 'web'
        ]);
		
		//end create web permission 'view owners'
		
		
		//Create admin role and give him permissions and assign role to some user/users  
		$adminRole = Role::firstOrCreate([  //mega test fix for error 'There is no role named `admin` for guard `web`.'
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
		
	
	    $adminRole->syncPermissions([
			$permissionViewOwner
		]);  //multiple permission to role
		//end Create admin role and give him permissions and assign role to some user/users 
		
		$user = factory(\App\User::class)->create();
		
		User::first()->assignRole('admin');
		
        $this->actingAs(User::first());
		
		
		
		// Bypass policy or mock it. Policies use Gate under the hood
        Gate::shouldReceive('authorize')
            ->with('view', \App\Models\Owner::class)
            ->andReturn(true);
			
		// Act: call the route
        $response = $this->get(route('ownerOneId',   ['id' => $result->first()->id]));

        // Assert: correct view and data
        $response->assertStatus(200);
        $response->assertViewIs('owner.viewOne');
        $response->assertViewHasAll([
            'owner',
        ]);	
	}
        
	
	
	
	/** @test  route('owner/save') with wrong validation. Does not have Spatie permission access
	*/
    public function testSaveFailsBecauseOfValidation()
    {
		
		$user = factory(\App\User::class)->create();
				
        $this->actingAs(User::first());
		
		//Test itself
        //send incomplete data, validation should fail
        $response = $this->post(route('owner/save'), [
            'first_name' => '',
            'last_name'  => '',
			'email'      => 'realemail@gmail.com'
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', /*'email',*/ 'phone', 'location']);
    }
	
	
	
	/** @test  route('owner/save') with correct validation, should create new owner, Does not have Spatie permission access
	*/
    public function testCreatesNewOwnerWithVenues()
    {
		//$this->withoutExceptionHandling(); //to see errors
		
		$user = factory(\App\User::class)->create();
				
        $this->actingAs(User::first());
		
		//create 2 venues with attached equipments
		$venues = factory(\App\Models\Venue::class, 2)->create()->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
		});
		
		//testing itself
        //send validated request
        $response = $this->post('owner/save', [
            'first_name'  => 'Dima',
            'last_name'   => 'Dima',
			'email'       => 'realemail@gmail.com',
			'phone'       => '+380977678988', 
			'location'    => 'UAE',
			'owner_venue' => $venues->pluck('id')->toArray(), //array of venues ids to be  attached to owner (later in Api Controller)
        ]);

		
		$response->assertSessionDoesntHaveErrors();  //no validation errors
		
		 // Then: The owner should exist in the database
        $this->assertDatabaseHas('owners', [
            'email'      => 'realemail@gmail.com',
            'first_name' => 'Dima',
        ]);

		// And: The owner should have the correct venues attached
        $owner = Owner::where('email', 'realemail@gmail.com')->first();
        $this->assertCount(2, $owner->venues);
		
		
		// assert owners was created with correct  values 
		$this->assertEquals('Dima', Owner::first()->getOriginal('first_name')); //ignore accessor //expected/actual
		
		$this->assertCount(2, Venue::all()); //expected/actual
		
		//assert owner was created and redirected back............
		$response->assertRedirect();
        $response->assertSessionHas('flashSuccess');
		
		// And: The response should redirect with success flash message
        $response->assertRedirect('/owner-create'); // Adjust based on your actual redirect
        $response->assertSessionHas('flashSuccess', 'Owner was created successfully');
    }
	
	
	


    /** @test  route('owner/update') with wrong validation. Does not have Spatie permission access
	*/
    public function testUpdateFailsBecauseOfValidation()
    {
		
		// now unset/ de-register all the roles and permissions by clearing the permission cache
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
		//$this->withoutExceptionHandling(); //to see errors
		
		$ownersQuantity = 12;
		
		//create owners, venues, equipments
		$result = factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
			//create hasMany relation (Venues attached to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments attached to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
			});
				
		});
		
		$user = factory(\App\User::class)->create();
				
        $this->actingAs(User::first());
		
		
		//Test itself
        //send incomplete data, validation should fail
        $response = $this->put(route('owner/update', $result->first()->id), [
		   // 'owner_id'   => $result->first()->id,
            'first_name' => '',
            'last_name'  => '',
			'email'      => 'realemail@gmail.com'
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', /*'email',*/ 'phone', 'location']);
    }
	
	
	
		
	/** @test  route('owner/update') with correct validation, should update new owner, Does not have Spatie permission access
	*/
    public function testUpdatewOwnerWithVenues()
    {
		//$this->withoutExceptionHandling(); //to see errors
		
		$ownersQuantity = 12;
		
		//create owners, venues, equipments
		$result = factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
			//create hasMany relation (Venues attached to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments attached to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
			});
		});
		
		$user = factory(\App\User::class)->create();
				
        $this->actingAs(User::first());
		
	
		
		//testing itself
        //send validated request
        $response = $this->put(route('owner/update', $result->first()->id), [    // same as => put('owner/update/' . $result->first()->id, [
		    //'owner_id'    => $result->first()->id,
            'first_name'  => 'Dima',
            'last_name'   => 'Dima',
			'email'       => 'realemail2@gmail.com',
			'phone'       => '+380977678988', 
			'location'    => 'UAE',
			'owner_venue' => Venue::take(2)->pluck('id')->toArray(), //array of venues ids to be  attached to owner (later in Api Controller)
        ]);

		
		$response->assertSessionDoesntHaveErrors();  //no validation errors
		
		//dd(Owner::find($result->first()->id));
		$owner =Owner::find($result->first()->id);
		
		 // Then: The owner should exist in the database
        $this->assertDatabaseHas('owners', [
            'email'      => 'realemail2@gmail.com',
            'first_name' => 'Dima',
        ]);

		// And: The owner should have the correct venues attached
        $owner = Owner::where('email', 'realemail2@gmail.com')->first();
        $this->assertCount(2, $owner->venues);
		
		
		// assert owners was created with correct  values 
		$this->assertEquals('Dima', $owner->getOriginal('first_name')); //ignore accessor //expected/actual
		
		$this->assertCount(24, Venue::all()); //expected/actual
		
		//assert owner was created and redirected back............
		$response->assertRedirect();
        $response->assertSessionHas('flashSuccess');
		
		// And: The response should redirect with success flash message
        $response->assertRedirect('/owner/' . $owner->id); // Adjust based on your actual redirect
        $response->assertSessionHas('flashSuccess', 'Owner was updated successfully!!!!');
    }
	
	
	
	 /** @test */
    public function it_deletes_owner_and_soft_deletes_related_venues()
    {
        $ownersQuantity = 12;
		
		//create owners, venues, equipments
		$result = factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
			//create hasMany relation (Venues attached to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments attached to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
			});
				
		});
        
		
		//create Web permission 'delete owners'
		$permissionDeleteOwners = Permission::firstOrCreate([  //mega PhpUnit test fix for error 'There is no permission named `delete owners` for guard `web`.'
            'name' => 'delete owners',
            'guard_name' => 'web'  
        ]);
		
		//Create admin role and give him permissions and assign role to some user/users  --------------------------------------
		$adminRole = Role::firstOrCreate([  //mega PhpUnit test fix for error 'There is no role named `admin` for guard `web`.'
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

		$adminRole->syncPermissions([
			$permissionDeleteOwners
		]);  //multiple permission to role
		
		$users = factory(\App\User::class, 2)->create(/*['id' => 1]*/);  //$user = User::factory()->create();
		
		$userWithPermission = User::first();
		
	    $userWithPermission->assignRole('admin');
				
		$this->actingAs($userWithPermission, 'web');
		
		
		//testing itself
		$owner = $result->first();  //the owner to delete
		//dd($owner->id);
		
        // Ensure the venues are created and related to the owner
        $this->assertCount(2, $owner->venues);
        $this->assertFalse($owner->venues->first()->trashed());  // The venue should not be soft deleted initially

        // Make a POST request to the route
        $response = $this->post(route('owner/delete-one-owner', [
		    'id' => $owner->id
		]));

		//dd($response);
		
        // Ensure the owner was deleted
        $this->assertDatabaseMissing('owners', ['id' => $owner->id]);

        // Ensure related venues are soft deleted
        //$this->assertTrue($owner->venues->first()->fresh()->trashed());  //owner already deleted 

        // Check the redirect with the flash message
        $response->assertRedirect('/owners');
        $response->assertSessionHas('flashSuccess', "Record {$owner->id} was deleted successfully");
    }
	
	
	
	
	
	
	
	
	
	
	
	


}
