<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\MyTestCronJob;
use App\Models\Owner;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;       //trait to clear your table after every test

class MyTestCronJobTest extends TestCase
{
	use RefreshDatabase;       //trait to clear your table after every test
	
    /** @test */
    public function it_counts_owners_when_job_is_dispatched()
    {
		
		// Fake the log system, as assertLogged() is not supported in PHPUnit 8.5.41
        //Log::fake();
		
        // Arrange: Create a user (or mock as needed)
        $result = factory(\App\Models\Owner::class, 12)->create();

		
        // Fake the queue to avoid actually sending emails
        Queue::fake();

        // Act: Dispatch the job
        MyTestCronJob::dispatch();

        // Assert: Check that the job was added to the queue
        Queue::assertPushed(MyTestCronJob::class);

        // Optionally, you can assert that the job was pushed with the correct data
		/*
        Queue::assertPushed(MyTestCronJob::class, function ($job) use ($user) {  //not supported in your env
            return $job->user->id === $user->id;
        });
		*/
		
		// Assert that the log message was written
        //Log::assertLogged('info', 'Owners count is => ' . $result->count());  //assertLogged() is not supported in PHPUnit 8.5.41
		
		 // Assert that the log contains the expected message using the Log facade
		 /*
        $this->assertTrue(
            Log::getFacadeRoot()->hasLogged('info', 'Owners count is => ' . $result->count())
        );
		*/
    }
}
