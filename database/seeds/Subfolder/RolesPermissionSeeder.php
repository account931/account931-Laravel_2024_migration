<?php
//create Roles, permission and assign them to 1 user
namespace Database\Seeds\Subfolder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {		
		DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        DB::table('roles')->truncate(); //way to set auto increment back to 1 before seeding a table
		DB::table('permissions')->truncate();
		
		/*
		if (count(Role::findByName('admin')->get()) <= 0 ) {
	        $role = Role::create(['name' => 'admin']);
	    }
		*/
	     
		$role = Role::create(['name' => 'admin']);
		
	    $permissionViewOwner    = Permission::create(['name' => 'view owner']);
	    $permissionViewOwners   = Permission::create(['name' => 'view owners']);
        $permissionEditOwner    = Permission::create(['name' => 'edit owners']);
	    $permissionDeleteOwner  = Permission::create(['name' => 'delete owners']);
	
	    $permissionNotForAdmin  = Permission::create(['name' => 'not admin permission']);
	
	    //$role->givePermissionTo($permission);
	    $role = Role::findByName('admin');
	    $role->syncPermissions([$permissionViewOwner, $permissionViewOwners, $permissionEditOwner, $permissionDeleteOwner]);  //multiple permission to role

	    User::find(1)->assignRole('admin');
		
    
    }
}
