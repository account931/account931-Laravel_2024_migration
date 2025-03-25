<?php
//Api Controller for Owner
namespace App\Http\Api\V1\Controllers;

use App\Models\Owner;
use App\Support\Cachable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Api\V1\Resources\Owners\OwnerResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Api\V1\Collections\Owners\OwnerCollection;
use App\Models\Venue;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; //for in: validation
use App\Http\Requests\Owner\OwnerRequest; //my custom Form validation via Request Class (to create new blog & images in tables {wpressimages_blog_post} & {wpressimage_imagesstock})

class OwnerController extends Controller
{
	/**
     * Show list of all owners. 
     * @return \Illuminate\Http\Resources\Json\JsonResource;
     */
    public function index(Request $request): JsonResource
    {
		$onwers = Owner::createdAtLastYear()   //createdAtLastYear, confirmed == local scope
		            //->confirmed()  //local scope
		            ->with('venues', 'venues.equipments')  //eager loading ['venues' => 'hasMany relation in models\Owner', 'venues.equipments' => 'nested relation in models\Venue, i.e $owner->venues->equipments']
		            //->paginate(2); //version with pagination, dont use  ->get()  //navigate by => ?page=2
					->get(); 
					
		//return  OwnerResource::collection($onwers); //works, return collection of models through Resource, but without your customization (so u cann't add additional data like 'owners_count' => Owner::count(),'). Advantage: dont have to create your custom collection, just use build-in.
		//return response([ 'owners' => OwnerResource::collection($onwers), 'message' => 'Retrieved successfully'], 200); //v2
		return new OwnerCollection($onwers); //your custom Collection with your added data. Advantage: u can add additional data like 'owners_count' => Owner::count() 
		

		
		//Not supported, arrow functions were introduced in PHP 7.4 
        /*return Cachable::cache(
            fn () => OwnerResource::collection(
                Owner::all()
            )
        );*/
    }
	
	/**
     * Show one owner. By Implicit Route Model Binding
     * @param Owner $owner
     * @return \Illuminate\Http\Resources\Json\JsonResource;
     */
	public function show(Owner $owner): JsonResource
	{
		return  new OwnerResource($owner);
	}
	
	
	 /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Owner\OwnerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OwnerRequest $request)     //was Request $request    @param  \Illuminate\Http\Request  $request
    {
        $data = $request->all();
		
		/*
		$RegExp_Phone = '/^[+]380[\d]{1,4}[0-9]+$/';
		
		$existingVenues = Venue::active()->pluck('id'); 

        $validator = Validator::make($data, [
            'first_name' => 'required|string|min:3|max:255',
            'last_name'  => 'required|string|min:3|max:255',
            'location'      => 'required|string|min:3|max:255',
			'email'         => 'required|email|unique:owners,id,',  //email is unique on create only, not on update
			'phone'         => ['required', "regex: $RegExp_Phone" ],	
			'owner_venue'   => ['required', 'array',  ],               //Rule::in($existingVenues)
			"owner_venue.*" => Rule::in($existingVenues)
        ]);
		

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
		*/

        $owner = Owner::create($data);
		
		//my added line, as we need to attach venues to owner, same we do in http version
		$owner->venues()->saveMany(Venue::find($request->owner_venue)); //save hasMany

        return response([ 'owner' => new OwnerResource($owner), 'message' => 'Created successfully'], 200);
    }
	
	
	/**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Owner\OwnerRequest $request
     * @param  \App\Models\Owner $owner
     * @return \Illuminate\Http\Response
     */
	 //not tested!!!!!!!!!!!!!!!
    public function update(OwnerRequest $request, Owner $owner)    //OwnerRequest $request  
    {
		/* if (!$request->validated()){
			dd('zzzz');
		} */
		
		$data = $request->all();
		
		//do not get here
		/*
		if(!$request->wantsJson()){
			return response([ 'id' =>$id, 'message' => 'Retrieved successfully'], 200);
		} */

        //return response([ 'id' =>$id, 'message' => 'Retrieved successfully'], 200);
			
        $owner->update($request->all());
        return response([ 'owner' => new ownerResource($owner), 'message' => 'Updated successfully'], 200);
    }
    

	
	
    /**
     * Remove the specified resource from storage. Protected by Passport and Spatie permission delete owners',
     *
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
	
    public function destroy(Owner $owner)
    {
		$this->authorize('delete owners', Owner::class); //must have, Spatie RBAC Policy permission check (403 if fails (set in Policy). Instead of this you can also use it directly on route =>Route::middleware(['auth:api', 'can:update,post'])

        $owner->delete();

        return response(['message' => 'Deleted owner ' . $owner->id]);
    }
    
	
	/**
     * Returns owners quantity. Created to test Passport, user must be logged (tested in console and tests)
     * @return \Illuminate\Http\JsonResponse;
     */
	public function quantity(): JsonResponse
	{
		//return response([ 'owners quantity' => Owner::count(), 'message' => 'Retrieved successfully']);
		return response()->json([ 'status' => 'OK', 'owners quantity' => Owner::count(), ]);
	}
	
	/**
     * Returns owners quantity. Created to test Passport + Spatie RBAC(user must be logged and have permission 'view_owner_admin_quantity' (tested in console)
     * @return \Illuminate\Http\JsonResponse;
     */
	public function quantityAdmin(): JsonResponse
	{
		$this->authorize('view_owner_admin_quantity', Owner::class); //must have, Spatie RBAC Policy permission check (403 if fails (set in Policy). Instead of this you can also use it directly on route =>Route::middleware(['auth:api', 'can:update,post'])

		//return response([ 'owners quantity' => Owner::count(), 'message' => 'Retrieved successfully']);
		return response()->json([ 'status' => 'OK, Admin. You have Spatie permission', 'owners quantity' => Owner::count(), ]);
	}
	
}
