<?php

namespace Tests\Unit;

use App\Job;
use App\Repositories\ORMJobRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ORMJobRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private $table = 'jobs';
    /**
     * @var Job
     */
    private $job;
    /**
     * @var Job
     */
    private $postJob;
    /**
     * @var ORMJobRepository
     */
    private $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new ORMJobRepository();
    }


    public function testJobSave(): void
    {
        $this->whenJobSave();
        $this->thenDBHasJob();
    }

    public function testJobIsFound(): void
    {
        $this->givenJobIsCreated();
        $this->whenJobFound();
        $this->thenJobIsFound();
    }

    public function testJobIsDeleted(): void
    {
        $this->givenJobIsCreated();
        $this->whenJobIsDelete();
        $this->thenJobIsDeleted();
    }

    private function whenJobIsDelete(): void
    {
        $this->repo->delete($this->postJob->id);
    }

    private function thenJobIsDeleted(): void
    {
        $job = $this->postJob;
        $this->assertDeleted($this->table, [
            'id' => $job->id,
            'title' => $job->title
        ]);
    }


    private function givenJobIsCreated(): void
    {
        $this->postJob = factory(Job::class)->create();
    }

    private function whenJobFound(): void
    {
        $this->job = $this->repo->find($this->postJob->id);
    }

    private function thenJobIsFound(): void
    {
        $this->assertEquals($this->postJob->title, $this->job->title);
    }


    private function whenJobSave(): void
    {
        $this->job = factory(Job::class)->make();
        $this->repo->save($this->job);
    }
    private function thenDBHasJob(): void
    {
        $this->assertDatabaseHas($this->table, [
            'title' => $this->job->title
        ]);
    }
}
