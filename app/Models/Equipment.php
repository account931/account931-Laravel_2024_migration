<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder; //for scope
//use Illuminate\Database\Eloquent\Factories\HasFactory; //Factory traithas been introduced in Laravel v8.
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
	//use HasFactory; ////Factory trait has been introduced in Laravel v8.
	use SoftDeletes;
	
	 protected $table ='equipments';
	 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    ];
	
	 /**
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
    ];
	
	/**
     * BelongsToMany: get venues that have equipment
     */
    public function venues(): BelongsToMany
    {
        return $this->belongsToMany(Venue::class);
    }

}
