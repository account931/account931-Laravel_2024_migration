<?php

namespace App\Http\Api\V1\Controllers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Api\V1\Resources\OwnerResource;
use App\Models\Owner;
use App\Support\Cachable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class OwnerController extends Controller
{
    public function index(Request $request): JsonResource
    {
		$onwers = Owner::createdAtLastYear()->get(); //local scope
		return  OwnerResource::collection($onwers);
		
		//Not supported, arrow functions were introduced in PHP 7.4 
        /*return Cachable::cache(
            fn () => OwnerResource::collection(
                Owner::all()
            )
        );*/
    }
}
