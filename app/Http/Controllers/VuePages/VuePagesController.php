<?php

namespace App\Http\Controllers\VuePages;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller; //to place controller in subfolder
use App\Models\Owner;
use App\Models\Venue;
use App\Http\Requests\Owner\OwnerRequest; //my custom Form validation via Request Class (to create new blog & images in tables {wpressimages_blog_post} & {wpressimage_imagesstock})
use Illuminate\Http\Request;

class VuePagesController extends  Controller
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	 public function __construct(){
	    //$this->middleware('auth'); //logged users only	
	}
	
	/**
     * Show start page with all owners list
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {   
	    //using Policy. There 3 possible ways
	    //$this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        return view('vue-pages.index'); //->with(compact('name', 'owners'));
    }
	
	
}
