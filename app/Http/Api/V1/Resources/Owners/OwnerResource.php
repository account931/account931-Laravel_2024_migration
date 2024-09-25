<?php

namespace App\Http\Api\V1\Resources\Owners;

//use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Owner;
use App\Http\Api\V1\Resources\Venues\VenueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);  //working, will return all fields
		return [
            'id'            => $this->id,
            'first_name'    => $this->first_name,
			'last_name'     => $this->last_name,
            'confirmed'     => $this->confirmed,
            'venues'        => VenueResource::collection($this->venues), //hasMany relation (includes Many to Many relation 'equipments' inside)
			'status' => 'success',
	    ];
    }
}
