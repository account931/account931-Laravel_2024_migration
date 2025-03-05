<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
		//$this->withoutExceptionHandling(); //to see errors
        $response = $this->get('/');
		//$this->assertTrue(true);
        //$response->assertStatus(200); //tempo shut down
		$response->assertRedirect('/login');
    }
}
