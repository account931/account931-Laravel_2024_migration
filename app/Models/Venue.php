<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder; //for scope
//use Illuminate\Database\Eloquent\Factories\HasFactory; //Factory traithas been introduced in Laravel v8.
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Venue extends Model
{
	//use HasFactory; ////Factory trait has been introduced in Laravel v8.
	use SoftDeletes;
	
    protected $appends = ['location_json'];
	
	 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location', // Spatial column    
	];
	
	 
    protected $casts = [
	    // Optional: If you want to handle raw spatial data before saving it
        'coordinates' => 'point', // Using 'point' cast to automatically handle POINT type data   //Save =>   $location->coordinates = DB::raw("ST_GeomFromText('POINT(10 20)')"); // Raw SQL to create POINT
    ];
	
	

	
	//getter for, column 'location', sql type Point' //    // Accessor: Get lat/lon from POINT column
	public function getLocationAttribute()
    {
		
        // Extract POINT(lon lat) as text using MySQL's ST_AsText
        $point = DB::selectOne("SELECT ST_AsText(location) AS point FROM venues WHERE id = ?", [$this->id]);  //return POINT(69.96012 -11.910163

		//dd(gettype($point->point));  //object 
	    //dd($point->point);   
		
        // Check if the query returns a valid point
        if ($point && preg_match('/POINT\(([-\d.]+) ([-\d.]+)\)/', $point->point, $matches)) {
            // Return the latitude and longitude as floats
			
			
            return [
                'lon' => (float) $matches[1],
                'lat' => (float) $matches[2],
            ];
        } else {
            // Log or handle the error (using dd for now for debugging)
            //\Log::error('Invalid location data or unable to extract coordinates.', ['point' => $point]);
            dd('Invalid or missing location data: ' . print_r($point, true));  // Optionally use this to debug the point data
        }

        // Return null if no valid location data is found
        return null;
    }
	
	
	 /**
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
    ];
	
	 /**
     * Scope a query to only include active venues (local scope).
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', '=', 1);
    }
	
	/**
     * Scope a query to only include venues created last year (local scope).
     */
	public function scopeCreatedAtLastYear($query)
    {
        return $query->where('created_at', '>=', now()->subYear());
    }
	
	/**
     * BelongsTo: get the owner that owns the venue.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

	/**
     * BelongsToMany: get equipments that have venues
     */
    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class);
    }
}
