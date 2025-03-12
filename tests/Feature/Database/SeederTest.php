<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Database\Seeds\Subfolder\RolesPermissionSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends TestCase
{
	use RefreshDatabase;
	
     /** @test */
    public function testSeedsRolesPermissions()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        DB::table('users')->truncate();
		DB::table('roles')->truncate(); //way to set auto increment back to 1 before seeding a table
		DB::table('permissions')->truncate();
		
		$users = factory(\App\User::class, 2)->create();  //$user = User::factory()->create();
        //$user = $user->first();
			

        //dd($users->skip(1)->first());
		
        // Run the RoleSeeder
		$parameters = [
            '--class' => 'Database\\Seeds\\Subfolder\\RolesPermissionSeeder', // You can customize the client name here
        ];
        Artisan::call('db:seed', $parameters);
		

        // Assert that the 'admin' role exists
        $this->assertDatabaseHas('roles', [
            'name' => 'admin',
        ]);

        // Assert that the 'edit-posts' permission exists
        $this->assertDatabaseHas('permissions', [
            'name' => 'view owner',
        ]);
		
		$this->assertDatabaseMissing('permissions', [
            'name' => 'some-shit',
        ]);
		

        // Assert that the 'admin' role has the 'edit-posts' permission
        $adminRole = Role::where('name', 'admin')->first();
        $this->assertTrue($adminRole->hasPermissionTo('view owner'));
    }
}