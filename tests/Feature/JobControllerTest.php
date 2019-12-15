<?php

namespace Tests\Unit;

use App\Job;
use App\Repositories\BaseJobRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use \Illuminate\Foundation\Testing\TestResponse;

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
    /**
     * @var TestResponse
     */
    private $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockRepo = Mockery::mock(BaseJobRepository::class);
        $this->app->instance('App\Repositories\BaseJobRepository', $this->mockRepo);
    }

    public function testGetAllJobReq(): void
    {
        $this->givenJobsCreated(2);
        $this->givenPaginateShouldSet();
        $this->whenAllJobFound();
        $this->thenJobFetchSuccess(2);
    }

    public function testGetOneJobReq(): void
    {
        $this->givenJobsCreated(2);
        $this->givenOneJobShouldFound(0);
        $this->whenOneJobIsFetch(0);
        $this->thenOneJobIsFetchSuccess(0);
    }

    public function testOneJobPost(): void
    {
        $this->givenOnePostJob();
        $this->givenOneJobShouldSave();
        $this->whenOnePostJobReq();
        $this->thenOnePostJobReqSucccess();
    }

    public function testOneJobUpdate(): void
    {
        $newTitle = 'Android Developer';
        $this->givenJobsCreated(1);
        $this->givenOneJobShouldUpdate($this->jobs[0]->id);
        $this->whenOneJobIsUpdate($this->jobs[0]->id, $newTitle);
        $this->thenOneJobUpdateSuccess();
    }

    public function testOneJobDelete(): void
    {
        $this->givenJobsCreated(1);
        $this->givenOneJobShouldDelete($this->jobs[0]->id);
        $this->whenOneJobIsDelete($this->jobs[0]->id);
        $this->thenOneJobDeleteSuccess();
    }

    private function whenOneJobIsDelete(int $id): void
    {
        $this->response = $this->delete('/api/jobs/' . $id);
    }

    private function thenOneJobDeleteSuccess(): void
    {
        $this->response
            ->assertStatus(200);
    }

    private function givenOneJobShouldDelete(int $id): void
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[$id])->once();
        $this->mockRepo->shouldReceive('delete')
            ->with($id)->once();
    }

    private function whenOneJobIsUpdate(int $id, string $title): void
    {
        $this->response = $this->put(
            '/api/jobs/' . $id,
            [
                'title' => $title
            ]
        );
    }

    private function thenOneJobUpdateSuccess(): void
    {
        $this->response->assertStatus(200);
    }

    private function givenOneJobShouldUpdate(int $id): void
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[0])->once();
        $this->mockRepo->shouldReceive('save')->once();
    }


    private function givenOnePostJob(): void
    {
        $this->postJob = (factory(Job::class, 1)->make())[0];
    }

    private function givenOneJobShouldSave(): void
    {
        $this->mockRepo->shouldReceive('save')->once();
    }

    private function whenOnePostJobReq(): void
    {
        $this->response = $this->post(
            '/api/jobs',
            [
                'title' => $this->postJob->title,
                'description' => $this->postJob->description,
                'company_name' => $this->postJob->company_name
            ]
        );
    }

    private function thenOnePostJobReqSucccess(): void
    {

        $this->response->assertStatus(200);
    }

    private function givenJobsCreated(int $count): void
    {
        $this->jobs = factory(Job::class, $count)->make();
        for ($i = 0; $i < $count; $i++) {
            $this->jobs[0]->id = $i;
        }
    }

    private function givenOneJobShouldFound(int $id): void
    {
        $this->mockRepo->shouldReceive('find')->with($id)->andReturn($this->jobs[$id])->once();
    }

    private function givenPaginateShouldSet(): void
    {
        $this->mockRepo->shouldReceive('paginate')->andReturn($this->jobs)->once();
    }

    private function whenAllJobFound(): void
    {
        $this->response = $this->get('/api/jobs');
    }

    private function thenJobFetchSuccess(int $count): void
    {
        $this->response->assertStatus(200)->assertJsonCount($count, 'data');
    }

    private function whenOneJobIsFetch(int $id): void
    {
        $this->response = $this->get('/api/jobs/' . $id);
    }

    private function thenOneJobIsFetchSuccess(int $id): void
    {
        $this->response->assertStatus(200)
            ->assertJson(['data' => ['title' => $this->jobs[$id]->title]]);
    }
}
