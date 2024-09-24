<?php

namespace App\Http\Api\V1\Resources\Venues;

//use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Venue;
use Illuminate\Http\Resources\Json\JsonResource;

class VenueResource extends JsonResource
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
            'venue_name'    => $this->venue_name,
			'address'     => $this->address,
            'active'     => $this->active,
			'status' => 'success',
	    ];
    }
}
