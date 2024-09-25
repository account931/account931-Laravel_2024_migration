<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder; //for scope
//use Illuminate\Database\Eloquent\Factories\HasFactory; //Factory traithas been introduced in Laravel v8.
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Venue extends Model
{
	//use HasFactory; ////Factory trait has been introduced in Laravel v8.
	use SoftDeletes;
	
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
