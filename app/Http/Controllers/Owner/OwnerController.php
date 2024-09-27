<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller; //to place controller in subfolder
use App\Models\Owner;

class OwnerController extends  Controller
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	 public function __construct(){
	    //$this->middleware('auth'); //logged users only	
        //session_start();		
	}
	
	/**
     * Show start page with all owners list
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {   
	    $name   = 'All records';
        $owners = Owner::createdAtLastYear() //createdAtLastYear, confirmed == local scope
             //->confirmed()  //local scope
            ->with('venues', 'venues.equipments')  //eager loading ['venues' => 'hasMany relation in models\Owner', 'venues.equipments' => 'nested relation in models\Venue, i.e $owner->venues->equipments']
            ->paginate(10);
        return view('owner.index')->with(compact('name', 'owners'));
    }
	
	/**
     * Show one owner. By Implicit Route Model Binding
     * @param Owner $owner
     * @return \Illuminate\Http\Response
     */
	public function show(Owner $owner) {  
	    //$equipment = Owner::where('id', $id)->firstOrFail(); 		   
	    return view('owner.viewOne',  compact('owner'));
	}
	
	/**
     * Show one owner. By traditional id
     * @param integer $id 
     * @return \Illuminate\Http\Response
     */
	public function showById($id) {   
	    $owner = Owner::where('id', $id)->firstOrFail(); 		   
	    return view('owner.viewOne',  compact('owner'));
	}
	
	
}
