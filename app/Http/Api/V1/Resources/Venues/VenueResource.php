<?php

namespace App\Http\Api\V1\Resources\Venues;

//use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Venue;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Api\V1\Resources\Equipments\EquipmentResource;

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
			'address'       => $this->address,
            'active'        => $this->active,
			'equipments'    => EquipmentResource::collection($this->equipments), //add many to Many relation ($this->equipments)
			'status'        => 'success',
	    ];
    }
}
