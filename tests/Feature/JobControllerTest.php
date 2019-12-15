<?php

namespace Tests\Unit;

use App\Job;
use App\Repositories\BaseJobRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class JobControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    private $table = 'jobs';
    /**
     * @var array
     */
    private $jobs;
    /**
     * @var Job
     */
    private $postJob;
    /**
     * @var BaseJobRepository
     */
    private $mockRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepo = Mockery::mock(BaseJobRepository::class);
        $this->app->instance('App\Repositories\BaseJobRepository', $this->mockRepo);
    }

    public function testGetAllJobReq(): void
    {
        $this->givenJobsCreated(2);
        $this->whenAllJobFound();
        $this->thenJobFetchSuccess(2);
    }

    public function testGetOneJobReq(): void
    {
        $this->givenJobsCreated(2);
        $this->whenOneJobFound(0);
        $this->thenOneJobIsFetchSuccess(0);
    }

    public function testOneJobPost(): void
    {
        $this->givenOnePostJob();
        $this->whenJobIsSave();
        $this->thenOnePostJobReqSucccess();
    }

    public function testOneJobUpdate(): void
    {
        $newTitle = 'Android Developer';
        $this->givenJobsCreated(1);
        $this->whenOneJobUpdateReq($this->jobs[0]->id);
        $this->thenOneJobUpdateSuccess($this->jobs[0]->id, $newTitle);
    }

    public function testOneJobDelete(): void
    {
        $this->givenJobsCreated(1);
        $this->whenOneJobDeleteReq($this->jobs[0]->id);
        $this->thenOneJobDeleteSuccess($this->jobs[0]->id);
    }

    private function thenOneJobDeleteSuccess(int $id): void
    {
        $this->delete('/api/jobs/' . $id)
            ->assertStatus(200);
    }

    private function whenOneJobDeleteReq(int $id): void
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[$id])->once();
        $this->mockRepo->shouldReceive('delete')
            ->with($id)->once();
    }

    private function thenOneJobUpdateSuccess(int $id, string $title): void
    {
        $this->put(
            '/api/jobs/' . $id,
            [
                'title' => $title
            ]
        )->assertStatus(200);
    }

    private function whenOneJobUpdateReq(int $id): void
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[0])->once();
        $this->mockRepo->shouldReceive('save')->once();
    }


    private function givenOnePostJob(): void
    {
        $this->postJob = (factory(Job::class, 1)->make())[0];
    }

    private function whenJobIsSave(): void
    {
        $this->mockRepo->shouldReceive('save')->once();
    }

    private function thenOnePostJobReqSucccess(): void
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

    private function givenJobsCreated(int $count): void
    {
        $this->jobs = factory(Job::class, $count)->make();
        for ($i = 0; $i < $count; $i++) {
            $this->jobs[0]->id = $i;
        }
    }

    private function whenOneJobFound(int $id): void
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[$id])->once();
    }

    private function whenAllJobFound(): void
    {
        $this->mockRepo->shouldReceive('paginate')->andReturn($this->jobs)->once();
    }

    private function thenJobFetchSuccess(int $count): void
    {
        $this->get('/api/jobs')->assertStatus(200)->assertJsonCount($count, 'data');
    }

    private function thenOneJobIsFetchSuccess(int $id): void
    {
        $this->get('/api/jobs/' . $id)->assertStatus(200)
            ->assertJson(['data' => ['title' => $this->jobs[$id]->title]]);
    }
}
