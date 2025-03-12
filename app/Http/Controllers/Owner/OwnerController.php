<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller; //to place controller in subfolder
use App\Models\Owner;
use App\Models\Venue;
use App\Http\Requests\Owner\OwnerRequest; //my custom Form validation via Request Class (to create new blog & images in tables {wpressimages_blog_post} & {wpressimage_imagesstock})
use Illuminate\Http\Request;

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
	    //using Policy. There 3 possible ways
		// way 1 
	    $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)
		
		// way 2, tested
		/* 
		if (auth()->user()->cannot('index', Owner::class)) {
            abort(403, 'Sorry, index failed, ID does not match 1');
        } */
		
		//way 3 (not tested), Via Middleware, e.g =>  Route::put('/post/{post}', function (Post $post) {
                                                     // The current user may update the post...
                                        //})->middleware('can:index, owner');
		
		
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
        
        $this->authorize('view', Owner::class); //must have, Spatie RBAC Policy permission check (403 if fails (set in Policy)
				
	    $owner = Owner::where('id', $id)->firstOrFail(); 		   
	    return view('owner.viewOne',  compact('owner'));
	}
	
	/**
     * Create new owner form
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function create() {   
	    $venues = Venue::active()->get();//gets venues for dropdown select
	    return view('owner.create', compact('venues'));
	}
	
    /**
     * Save new owner form data
     * @param  OwnerRequest $request       \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function save(OwnerRequest $request) { 
        //dd($request->all());	
		//dd($request->owner_venue);
		
		$data = $request->input();
		
	    try{
			//should be transaction in the end
			$owner = new Owner();
			$owner->first_name = $data['first_name'];
			$owner->last_name  = $data['last_name'];
			$owner->email      = $data['email'];
			$owner->phone      = $data['phone'];
			$owner->location   = $data['location'];
			$owner->save();
			
			$owner->venues()->saveMany(Venue::find($request->owner_venue)); //save hasMany
			
			return redirect('/owner-create')->with('flashSuccess', "Owner was created successfully");
			
		} catch(Exception $e){
			return redirect('/owner-create')->with('flashFailure', "Operation failed");
		}
	}
	
	/**
     * Edit owner form
	 * @param Owner $owner
     * @return \Illuminate\Contracts\Support\Renderable
     */
	public function edit(Owner $owner) {  
	    $this->authorize('update', Owner::class); //must have, Spatie RBAC Policy permission check (403 if fails (set in Policy)
		
        $venues = Venue::active()->get();//gets venues for dropdown select	
	    return view('owner.edit', compact('owner', 'venues'));
	}
	
	/**
     * Update edited  owner form
	 * @param  OwnerRequest $request 
     * @return \Illuminate\Http\Response
     */
	public function update(OwnerRequest $request) {  
        //dd($request->all());	
		//dd($request->owner_venue);
		
		//dd($request->owner_id);
		$id = $request->owner_id;
		$owner =  Owner::find($id); //->firstOrFail(); 
		//dd($owner);
		$data = $request->input();
		
	    try{
			//should be transaction in the end
			//$owner = new Owner();
			$owner->first_name = $data['first_name'];
			$owner->last_name  = $data['last_name'];
			$owner->email      = $data['email'];
			$owner->phone      = $data['phone'];
			$owner->location   = $data['location'];
			$owner->save();
			
			$owner->venues()->saveMany(Venue::find($request->owner_venue)); //save hasMany
			
			//return redirect()->back()->with('flashSuccess', "Owner was updated successfully!!!!");
			return redirect()->route('ownerOne',   ['owner' => $owner])->with('flashSuccess', "Owner was updated successfully!!!!"); 
			
		} catch(Exception $e){
			return redirect()->route('ownerOne',   ['owner' => $owner])->with('flashFailure', "Operation failed");
		}
	}
	
	
	
	 /**
     * Delete one owner
     * @param  Owner $id
     * @return \Illuminate\Http\Response
     */
	public function delete(Request $request) { 
	   //dd($request);
	   $owner = Owner::find($request->owner_id);
	   //dd($owner->venues->first()->venue_name);
	   
	   // remove relation connection in table 'Venues', otherwise when forceDeleting $owner it also deletes $venue from table 'venues' connected to $owner
	   //$owner->venues()->dissociate();  //dissociate() is for belongsTo only
	   //$owner->venues()->detach();   //detach() is for hasMany
	   $owner->venues()->delete(); //delete hasMany  //currently just set venues to be soft deleted
       $owner->save();
	   
	   //$owner->forceDelete();
	   $owner->delete();
	   
	   return redirect('/owners')->with('flashSuccess', "Record " . $request->owner_id  . " was deleted successfully");
	}
	
	
	
}
