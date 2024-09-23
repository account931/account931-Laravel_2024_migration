<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder; //for scope
//use Illuminate\Database\Eloquent\Factories\HasFactory; //Factory traithas been introduced in Laravel v8.

class Owner extends Model
{
	//use HasFactory; ////Factory trait has been introduced in Laravel v8.
	use SoftDeletes;
	
	 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
		'last_name',
    ];
	
	 /**
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        //'created'  => UserCreated::class,
        //'updated'  => UserUpdated::class,
        //'deleting' => UserDeleting::class,
        //'deleted'  => UserDeleted::class,
    ];
	
	 /**
     * Scope a query to only include confirmed owners (local scope).
     */
    public function scopeConfirmed(Builder $query): void
    {
        $query->where('confirmed', '=', 1);
    }
	
	/**
     * Scope a query to only include owners created last year (local scope).
     */
	public function scopeCreatedAtLastYear($query)
    {
        return $query->where('created_at', '>=', now()->subYear());
    }
	
	/**
     * Accessor: get the user's first name
     *
     * @param  string  $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return "<span style='color:red;font-size:0.7em;'>accessor</span> " . ucfirst($value);
    }

}
