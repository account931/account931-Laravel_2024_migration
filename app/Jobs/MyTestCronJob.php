<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Owner;
use Illuminate\Support\Facades\Log;

//php artisan queue:listen --queue=default,sync,process,notification   //is used to listen to and process jobs from one or more specified queues
//php artisan schedule:run   => use this to test cron job on localhost

class MyTestCronJob implements ShouldQueue
{
	use Dispatchable;
    use Queueable;
	
	/**
     * Create instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->queue = 'default';
    }

	public function handle(): void
    {
		$onwers = Owner::createdAtLastYear()   //createdAtLastYear, confirmed == local scope
		            //->confirmed()  //local scope
		            ->with('venues', 'venues.equipments')  //eager loading ['venues' => 'hasMany relation in models\Owner', 'venues.equipments' => 'nested relation in models\Venue, i.e $owner->venues->equipments']
		            //->paginate(2); //version with pagination, dont use  ->get()  //navigate by => ?page=2
					->get(); 
					
		
		//Log::info("Owners count is => " . $onwers->count());
		//$this->info("Owners count is => " . $onwers->count());
		//dd("Count is => " . $onwers->count());
		echo("Good");

		
	}
}
    