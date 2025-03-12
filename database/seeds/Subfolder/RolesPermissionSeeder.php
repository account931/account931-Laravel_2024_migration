<?php
//create Roles, permission and assign them to some users
//Manual: create some pesrmissions -> assign them to some roles -> assign this role to some user
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
	     
		//Create Permissions ------------------------------------------------------------------------------------------------
		//Owner permission
	    $permissionViewOwner    = Permission::create(['name' => 'view owner']);
	    $permissionViewOwners   = Permission::create(['name' => 'view owners']);
        $permissionEditOwner    = Permission::create(['name' => 'edit owners']);
	    $permissionDeleteOwner  = Permission::create(['name' => 'delete owners']);
	
	    //Role permission (view my custom Laravel Spatie Gui
		$permissionViewRole  = Permission::create(['name' => 'view roles']);
		
		//NB: API permission!!!!! Must have 'guard_name' => 'api', but gives an error. Fix: can run like this, then change in DB manually
		$permissionViewOwnerQauantityAdmin  = Permission::create(['name' => 'view owner admin quantity', 'guard_name' => 'web']); //permission to test API route /api/owner/quantity/admin
		
	    $permissionNotForAdmin  = Permission::create(['name' => 'not admin permission']); //some permission for test
		//End Create Permissions --------------------------------------------------------------------------------------------
		
		
		
		
		//Create admin role and give him permissions and assign role to some user/users  --------------------------------------
		$role = Role::create(['name' => 'admin']);
	
	    //$role->givePermissionTo($permission);
	    $role = Role::findByName('admin');
	    $role->syncPermissions([
		    $permissionViewOwner, 
			$permissionViewOwners, 
			$permissionEditOwner, 
			$permissionDeleteOwner,
			$permissionViewRole,
			$permissionViewOwnerQauantityAdmin
		]);  //multiple permission to role

	    User::find(1)->assignRole('admin');
		//End Create admin role and give him permissions  -----------------------------------------------------------------
		
		
		
		
		//Create user role and give him permissions and assign role to some user/users ------------------------------------
		$role = Role::create(['name' => 'user']);
		$role = Role::findByName('user');
	    $role->syncPermissions([$permissionViewOwner]);  //multiple permission to role
		
	    User::find(2)->assignRole('user');
		
    
    }
}
