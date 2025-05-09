<?php

//testing standart Login (via session),  see more Auth tests at => https://github.com/dczajkowski/auth-tests
namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
	use RefreshDatabase;
	//use WithoutMiddleware; // use this trait to disable CSRF on login ??? (as CSRF should be off by itself on testing)
	
    /**
     * A basic test example, tests nothing
     *
     * @return void
     */
    public function testVoid()
    {
        $this->assertTrue(true);
    }
	
	  /**
     * Test login form (working).
     *
     * @return void
     */
	public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
	
	public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }
	
	
	
	
	public function test_user_can_login_with_correct_credentials()
    {
		//$this->withoutExceptionHandling(); //to see errors
		
        $user = factory(User::class)->create([
		    'name'     => 'Dima',
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

		//dd($user);
        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);

		//$response->withSession(['user_id' => $user->id]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }
	
	
   public function test_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
        ]);
        
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);
        
		
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

	
	public function test_remember_me_functionality()
    {
        $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);
        
        $response->assertRedirect('/home');
        // cookie assertion goes here
        $this->assertAuthenticatedAs($user);
    }
	
	public function test_cookie_functionality()
    {
		 $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);
        
        $response->assertRedirect('/home');
		
	    $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
	}
	
}