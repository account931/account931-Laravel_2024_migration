<?php

namespace Tests\Feature\Http\Requests\Owner;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Owner;
use App\Models\Venue;
use App\User;
use App\Models\Equipment;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Testing\Fluent\AssertableJson; //in Laravel < 6 only

class OwnerRequestTest extends TestCase
{
	use DatabaseTransactions; //clear your table after every test
	
	public function testValidationFailsWithMissingLocation()
    {
		$user = factory(\App\User::class)->create();  //only logged can create owners, otherwise the request goes to /login
		$this->actingAs($user);
		  
        $response = $this->post('/owner/save', [
            'first_name'    => 'Dima',
            'first_name'    => 'D',
        ]);
		
        //dd($response->getContent());
		
        $response->assertStatus(302); // Expecting a redirect due to validation failure
		$response->assertSessionHasErrors();
        $response->assertSessionHasErrors('location');
    }
	
	 public function testValidationFailsWithInvalidEmail()
    {
		$user = factory(\App\User::class)->create();  //only logged can create owners, otherwise the request goes to /login
		$this->actingAs($user);
		
        $response = $this->post('/owner/save', [
            'first_name'    => 'Dima',
            'email'         => 'invalid-email',
        ]);

        // Check if the response contains the validation error message
        $response->assertStatus(302); // Expecting a redirect due to validation failure
		$response->assertSessionHasErrors();
        $response->assertSessionHasErrors('email');
    }
	
	/**
     * Test validation for invalid type of 'owner_venue' field.
     *
     * @return void
     */
    public function test_owner_venue_field_must_be_an_array()
    {
		$user = factory(\App\User::class)->create();  //only logged can create owners, otherwise the request goes to /login
		$this->actingAs($user);
		
        $response = $this->postJson('/owner/save', [
            'owner_venue' => 'not-an-array', // Invalid data (string instead of array)
        ]);

		//$response->assertStatus(302); // Expecting a redirect due to validation failure
        $response->assertStatus(422); // Assert validation error status
        $response->assertJsonValidationErrors(['owner_venue']); // Assert validation error for 'owner_venue' field
    }
	
	/**
     * Test validation for 'first_name' field length.
     *
     * @return void
     */
    public function test_name_field_length()
    {
		$user = factory(\App\User::class)->create();  //only logged can create owners, otherwise the request goes to /login
		$this->actingAs($user);
		
		// Test too short
        $response = $this->postJson('/owner/save', [
            'first_name' => 'A', // Too short
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['first_name']);

        // Test too long
		  $response = $this->postJson('/owner/save', [
            'first_name' => str_repeat('A', 256), // Too long
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['first_name']);
    }
    
	/**
     * Test custom validation error messages.
     *
     * @return void
     */
    public function test_custom_validation_messages()
    {
        // Test missing last_name
        $user = factory(\App\User::class)->create();  //only logged can create owners, otherwise the request goes to /login
		$this->actingAs($user);
		
		//Missing last_name
        $response = $this->postJson('/owner/save', [
            'first_name' => 'Dima', 
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'last_name' => ['Kindly asking for a last name'], // Custom message for required name
        ]);

        // Test first_name too short
          $response = $this->postJson('/owner/save', [
            'first_name' => 'D', 
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'first_name' => ['The first name must be at least 3 characters.'],
        ]);
    }

}
