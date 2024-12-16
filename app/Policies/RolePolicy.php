<?php
//To work Controller must contain, for example,  $this->authorize('view', Owner::class)  or other ways (see OwnerController/index)
namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
	
	/**
	* see all models (must be use viewAny instead of index ??)
	*/
	public function viewAny(User $user)
    {
		 return $user->can('view roles')   //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Stopped by OwnerPolicy, the User does not have permission "view roles"'); //way to add custom message
	}
	
		
	
}
