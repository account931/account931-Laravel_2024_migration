<?php

namespace App\Http\Api\V1\Resources\Equipments;

//use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Equipment;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
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
            'id'              => $this->id,
            'trademark_name'  => $this->trademark_name,
			'model_name'      => $this->model_name,
            //'description'     => $this->description,
	    ];
    }
}
