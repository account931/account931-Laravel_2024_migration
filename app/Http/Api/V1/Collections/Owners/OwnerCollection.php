<?php
//custom ResourceCollection, used to modified data (add your data, like calc)
//your custom Collection with your added data. Advantage: u can add additional data like 'owners_count' => Owner::count() 
//If need just to return model data only, use in App\Http\Api\V1\Controllers\OwnerController => OwnerResource::collection($onwers);. In this case this file can be deleted
//But it will return all models attribute, regardless specified in App\Http\Api\V1\Resources\Owners\OwnerResource
namespace App\Http\Api\V1\Collections\Owners;

//use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Api\V1\Resources\Venues\VenueResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Api\V1\Resources\Owners\OwnerResource;

class OwnerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		return [
            'data'                   => OwnerResource::collection($this->collection), //$this->collection == will return all attributes regardless specified in App\Http\Api\V1\Resources\Owners\OwnerResource // OwnerResource::collection($this->collection)  == will return only attributes specified in App\Http\Api\V1\Resources\Owners\OwnerResource
            'owners_count'           => Owner::count(),
            'owners_confirmed_count' => Owner::confirmed()->count(), //local scope
	    ];
    }
}
