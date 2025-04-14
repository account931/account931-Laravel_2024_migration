<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\MyTestCronJob;

//php artisan queue:listen --queue=default,sync,process,notification      // is used to listen to and process jobs from one or more specified queues 
//php artisan schedule:run   => use this to test cron job on localhost

class MyTestCronJobCommand extends Command
{
	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:testcronjob';  //can run in console with => php artisan my:testcronjob
    protected $description = 'My custom cron job command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Your cron job logic goes here
        //\Log::info('Cron job ran successfully!');
		MyTestCronJob::dispatch();
	    //$this->info("Job is done");
    }
}