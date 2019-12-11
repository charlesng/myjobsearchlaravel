<?php

namespace Tests\Unit;

use App\Http\Controllers\JobController;
use App\Job;
use App\Repositories\BaseJobRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class JobControllerTest extends TestCase
{
    use RefreshDatabase;

    private $table = 'jobs';
    private $jobs;
    private $postJob;
    /**
     * @var JobController
     */
    private $controller;
    private $mockRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepo = Mockery::mock(BaseJobRepository::class);
        $this->app->instance('App\Repositories\BaseJobRepository', $this->mockRepo);
    }

    public function testGetAllJobReq()
    {
        $this->givenJobsCreated(2);
        $this->whenAllJobFound();
        $this->thenJobFetchSuccess(2);
    }

    public function testGetOneJobReq()
    {
        $this->givenJobsCreated(2);
        $this->whenOneJobFound(0);
        $this->thenOneJobIsFetchSuccess(0);
    }

    public function testOneJobPost()
    {
        $this->givenOnePostJob();
        $this->whenJobIsSave();
        $this->thenOnePostJobReqSucccess();
    }

    public function testOneJobUpdate()
    {
        $newTitle = 'Android Developer';
        $this->givenJobsCreated(1);
        $this->whenOneJobUpdateReq($this->jobs[0]->id);
        $this->thenOneJobUpdateSuccess($this->jobs[0]->id, $newTitle);
    }

    public function testOneJobDelete()
    {
        $this->givenJobsCreated(1);
        $this->whenOneJobDeleteReq($this->jobs[0]->id);
        $this->thenOneJobDeleteSuccess($this->jobs[0]->id);
    }

    private function thenOneJobDeleteSuccess($id)
    {
        $this->delete('/api/jobs/' . $id)
            ->assertStatus(200);
    }

    private function whenOneJobDeleteReq($id)
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[$id])->once();
        $this->mockRepo->shouldReceive('delete')
            ->with($id)->once();
    }

    private function thenOneJobUpdateSuccess($id, $title)
    {
        $this->put(
            '/api/jobs/' . $id,
            [
                'title' => $title
            ]
        )->assertStatus(200);
    }

    private function whenOneJobUpdateReq($id)
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[0])->once();
        $this->mockRepo->shouldReceive('save')->once();
    }


    private function givenOnePostJob()
    {
        $this->postJob = (factory(Job::class, 1)->make())[0];
    }

    private function whenJobIsSave()
    {
        $this->mockRepo->shouldReceive('save')->once();
    }

    private function thenOnePostJobReqSucccess()
    {
        $this->post(
            '/api/jobs',
            [
                'title' => $this->postJob->title,
                'description' => $this->postJob->description,
                'company_name' => $this->postJob->company_name
            ]
        )->assertStatus(200);
    }

    private function givenJobsCreated($count)
    {
        $this->jobs = factory(Job::class, $count)->make();
        for ($i = 0; $i < $count; $i++) {
            $this->jobs[0]->id = $i;
        }
    }

    private function whenOneJobFound($id)
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[$id])->once();
    }

    private function whenAllJobFound()
    {
        $this->mockRepo->shouldReceive('paginate')->andReturn($this->jobs)->once();
    }

    private function thenJobFetchSuccess($count)
    {
        $this->get('/api/jobs')->assertStatus(200)->assertJsonCount($count, 'data');
    }

    private function thenOneJobIsFetchSuccess($id)
    {
        $this->get('/api/jobs/' . $id)->assertStatus(200)
            ->assertJson(['data' => ['title' => $this->jobs[$id]->title]]);
    }
}
