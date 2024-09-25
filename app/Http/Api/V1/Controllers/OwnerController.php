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
    public function index(Request $request): JsonResource
    {
		$onwers = Owner::createdAtLastYear()   //createdAtLastYear, confirmed == local scope
		            //->confirmed()  //local scope
		            ->with('venues')  //eager loading
		            ->get(); //local scope
		return  OwnerResource::collection($onwers); //works, return collection of models through Resource, but without your customization
		//return new OwnerCollection($onwers); //custom Collection with your added data (Issue: return everything from model, regadless what specified in Resource(inc relation))
		
		//Not supported, arrow functions were introduced in PHP 7.4 
        /*return Cachable::cache(
            fn () => OwnerResource::collection(
                Owner::all()
            )
        );*/
    }
}
