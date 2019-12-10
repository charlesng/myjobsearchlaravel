<?php

namespace Tests\Unit\database;

use App\Job;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobTableTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    private $jobs;

    public function testIfJobDataSet()
    {
        $this->givenJobsCreated();
        $this->thenJobIsCreated();
    }

    private function givenJobsCreated()
    {
        $this->jobs = factory(Job::class, 1)->create();
    }

    private function thenJobIsCreated()
    {
        $this->assertDatabaseHas('jobs', [
            'title' => $this->jobs[0]->title
        ]);
    }
}
