<?php
//This policy is for testing purpose mainly. In this case it authorize if user id is 1
//To work Controller must contain, for example,  $this->authorize('view', Owner::class)  or other ways (see OwnerController/index)
namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Owner;
use Illuminate\Auth\Access\Response;

class OwnerPolicy
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
	
	public function index(User $user)
    {
        return $user->can('view owners')   //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Stopped by OwnerPolicy, the User does not have permission "view owners"'); //way to add custom message
			   
		//return $user->can('access campaigns');
		//return $user->id === $owner->user_id;
    }

	/**
	* see all models (must be use viewAny instead of index ??)
	*/
	
	/*
	public function viewAny(User $user)
    {
		return $user->id === 1;
	}
	*/
		
	/**
	* see individual models
	*/
	public function view(User $user)
    {
        return $user->can('view owner')   //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Cannot see 1 model, stopped by OwnerPolicy, the User does not have permission "view owner"'); //way to add custom message
    }

	
    public function update(User $user)
    {
		return $user->can('edit owners')   //return $user->id === 1
		       ? Response::allow()
			   : Response::deny('Cant update, Stopped by OwnerPolicy, the User does not have permission "edit owners"');; //way to add custom message
    }
	

	/*
    public function delete(User $user, Owner owner)
    {
        return $user->id === $owner->user_id;
    }
	*/
}
