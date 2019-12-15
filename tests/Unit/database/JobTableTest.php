<?php

namespace Tests\Unit\database;

use App\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobTableTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return array
     */
    private $jobs;

    public function testIfJobDataSet(): void
    {
        $this->givenJobsCreated();
        $this->thenJobIsCreated();
    }

    private function givenJobsCreated(): void
    {
        $this->jobs = factory(Job::class, 1)->create();
    }

    private function thenJobIsCreated(): void
    {
        $this->assertDatabaseHas('jobs', [
            'title' => $this->jobs[0]->title
        ]);
    }
}
