<?php

namespace Tests\Unit;

use App\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobControllerTest extends TestCase
{
    use RefreshDatabase;

    private $table = 'jobs';
    private $jobs;
    private $postJob;

    public function testGetAllJobReq()
    {
        $this->givenJobsCreated(2);
        $this->thenOneJobIsFound(2);
    }

    public function testGetOneJobReq()
    {
        $this->givenJobsCreated(2);
        $this->thenOneJobIsFetch($this->jobs[0]->id);
    }

    public function testOneJobPost()
    {
        $this->givenOnePostJob();
        $this->whenOnePostJobReq();
        $this->thenOneJobIsCreatedInDB($this->postJob);
    }

    public function testOneJobUpdate()
    {
        $newTitle = 'Android Developer';
        $this->givenJobsCreated(1);
        $this->whenOneJobUpdateReq($this->jobs[0]->id, $newTitle);
        $this->thenJobInDBShouldUpdate($newTitle);
    }

    public function testOneJobDelete()
    {
        $this->givenJobsCreated(1);
        $this->whenOneJobDeleteReq($this->jobs[0]->id);
    }

    private function thenJobInDBShouldDeleted($job)
    {
        $this->assertDeleted($this->table, [
            'id' => $job->id,
            'title' => $job->title
        ]);
    }

    private function whenOneJobDeleteReq($id)
    {
        $this->delete('/api/jobs/' . $id)
            ->assertStatus(200);
    }

    private function thenJobInDBShouldUpdate($title)
    {
        $this->assertDatabaseHas($this->table, [
            'title' => $title
        ]);
    }

    private function whenOneJobUpdateReq($id, $title)
    {
        $this->put(
            '/api/jobs/' . $id,
            [
                'title' => $title
            ]
        )->assertStatus(200);
    }


    private function givenOnePostJob()
    {
        $this->postJob = (factory(Job::class, 1)->make())[0];
    }

    private function whenOnePostJobReq()
    {
        $this->post(
            '/api/jobs',
            [
                'title' => $this->postJob->title,
                'description' => $this->postJob->description,
                'company_name' => $this->postJob->company_name
            ]
        )->assertStatus(201);
    }

    private function thenOneJobIsCreatedInDB($job)
    {
        $this->assertDatabaseHas($this->table, [
            'title' => $job->title
        ]);
    }

    private function givenJobsCreated($count)
    {
        $this->jobs = factory(Job::class, $count)->create();
    }

    private function thenOneJobIsFound($count)
    {
        $this->get('/api/jobs')->assertStatus(200)->assertJsonCount($count, 'data');
    }

    private function thenOneJobIsFetch($id)
    {
        $job = $this->jobs[$id];
        $this->get('/api/jobs/' . $job->id)->assertStatus(200)
            ->assertJson(['data' => ['title' => $job->title]]);
    }
}
