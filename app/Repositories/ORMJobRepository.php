<?php

namespace App\Repositories;

use App\Job;

class ORMJobRepository implements BaseJobRepository
{
    public function save(Job $job): Job
    {
        $job->save();
        return $job;
    }
    public function find(int $id): Job
    {
        $job = Job::findOrFail($id);
        return $job;
    }
    public function delete(int $id): Job
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return $job;
    }

    public function paginate()
    {
        return Job::paginate();
    }
}
