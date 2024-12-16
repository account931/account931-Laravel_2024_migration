<?php
//My manual Spatie Laravel permission 5.3 GUI
namespace App\Http\Controllers\SpatiePermissionGui;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller; //to place controller in subfolder
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SpatiePermissionGuiController extends  Controller
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	 public function __construct(){
	    //$this->middleware('auth'); //logged users only	
        //session_start();		
	}
	
	/**
     * Show start page with all roles/permissions list
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {   
	    //using Policy. There 3 possible ways, see other ways in OwnerController
		// way 1 
	    $this->authorize('viewAny', Role::class); //must have, Policy check (custom Policy mes if fails)
		
        $allRoles = Role::with('permissions', 'users')->get(); //get all roles with permissions  and users
		//dd($allRoles->first()->users()->first()->name);
		
        return view('spatie-permission-gui.index')->with(compact('allRoles'));
    }
	
}
