<?php

namespace App\Http\Api\V1\Controllers;

use App\Models\Owner;
use App\Support\Cachable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Api\V1\Resources\Owners\OwnerResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Api\V1\Collections\Owners\OwnerCollection;


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
}
