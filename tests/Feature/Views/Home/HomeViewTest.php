<?php

namespace Tests\Feature\Views\Home;

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

class HomeViewTest extends TestCase
{
	use DatabaseTransactions; //clear your table after every test

    public function test_home_can_be_rendered(): void
    {
		//Not supported in L 6
        //$view = $this->view('home', ['user' => Auth::user()]);
        //$view->assertSee(Auth::user()->name);
		
		$user = factory(\App\User::class, 1)->create(['name' => 'Dima']); //to avoid test crash when name is O'Conel, etc
		$this->actingAs(User::first(), 'web');  
		
		$response = $this->get('/home');  // Route you want to test
        $response->assertStatus(200);  // Assert the response is successful
        $response->assertViewIs('home');  // Check if the correct view is returned
		//$response->assertViewHas('variable_name', 'expected_value');
		$response->assertSee(User::first()->name);
		$response->assertSee(User::first()->created_at);
		$response->assertDontSee(User::first()->email);
    }
}
