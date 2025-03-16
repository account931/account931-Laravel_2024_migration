<?php

namespace Tests\Feature\RolesPermissions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test
use App\User;

class GeneratePermissionAndCheck extends TestCase
{
	use DatabaseTransactions; //clear your table after every test
	
	protected function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now de-register all the roles and permissions by clearing the permission cache
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
	
	
    /**
     * Test Admin permissions
     *
     * @return void
     */
    public function testPermissions()
    {
		//$this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
		
		//have to use this so far, {->forgetCachedPermissions() in setUp()} does not work (???) & tests crash as permissions already exist from other tests (test fail on creating permission with error 'Permission already exists')
        DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        DB::table('roles')->truncate(); //way to set auto increment back to 1 before seeding a table
		DB::table('permissions')->truncate();
			
		 // Create a permission
        $permission = Permission::create(['name' => 'edit-posts']);

        // Create a role and give it the permission
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo($permission);

        // Create a user and assign the 'admin' role
        $user = factory(\App\User::class, 1)->create();  //$user = User::factory()->create();
		$user = $user->first();
        $user->assignRole('admin');

        // Assert that the user has the 'edit-posts' permission
		$this->assertTrue($user->hasRole('admin'));
		//$this->assertTrue($user->hasPermission('edit-posts'));
        $this->assertTrue($user->can('edit-posts'));
		
    }
	
	public function test_user_does_not_have_permission_to_edit_posts()
    {
        // Create a permission
        $permission = Permission::create(['name' => 'edit-posts-2']);

        // Create a user without any roles or permissions
        $user = factory(\App\User::class, 1)->create();  //$user = User::factory()->create();
		$user = $user->first();

        // Assert that the user does not have the 'edit-posts-2' permission
		$this->assertFalse($user->hasRole('admin'));
		//$this->assertFalse($user->hasPermission('edit-posts-2'));
        $this->assertFalse($user->can('edit-posts-2'));
    }

    public function test_user_without_role_does_not_have_permission()
    {
        // Create a permission
        $permission = Permission::create(['name' => 'edit-posts-3']);

        // Create a user and assign no roles or permissions
        $user = factory(\App\User::class, 1)->create();  //$user = User::factory()->create();
        $user = $user->first();
		
        // Assert that the user does not have the 'edit-posts-3' permission
		$this->assertFalse($user->hasRole('admin'));
		//$this->assertFalse($user->hasPermission('edit-posts-3'));
        $this->assertFalse($user->can('edit-posts-3'));
    }
	
	
}
