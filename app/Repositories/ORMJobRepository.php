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
    public function find($id): Job
    {
        $job = Job::findOrFail($id);
        return $job;
    }
    public function delete($id): Job
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return $job;
    }
}
