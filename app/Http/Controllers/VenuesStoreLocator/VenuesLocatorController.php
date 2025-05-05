<?php
//open route, does not require Passport(access token)

namespace App\Http\Controllers\VenuesStoreLocator;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller; //to place controller in subfolder
use App\Models\Owner;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenuesLocatorController extends  Controller
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	 public function __construct(){
	    //$this->middleware('auth'); //logged users only	
	}
	
	/**
     * 
     * @return \Illuminate\View\View
     */
    public function index() 
    {   
	    //using Policy. There 3 possible ways
	    //$this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        return view('venue-store-locator.index'); //->with(compact('name', 'owners'));
    }
	
	
}
