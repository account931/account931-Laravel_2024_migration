<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

}
