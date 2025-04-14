<?php
// tests/Feature/UpdateUserNameCommandTest.php

namespace Tests\Feature\Console\Command;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;       //trait to clear your table after every test

class MyTestCronJobCommandTest extends TestCase
{
	use RefreshDatabase;       //trait to clear your table after every test

    /** @test */
    public function it_runs()
    {
        $result = factory(\App\Models\Owner::class, 12)->create();

        // Act: Call the console command
        $exitCode = Artisan::call('my:testcronjob', [
            //'userId' => $user->id,
            //'name' => 'New Name',
        ]);

        // Assert: Check the exit code (0 means success)
        $this->assertEquals(0, $exitCode);

        // Optionally, check the output
        //$this->assertStringContainsString('Good', Artisan::output());
    }
}