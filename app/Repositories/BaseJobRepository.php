<?php

namespace App\Repositories;

use App\Job;

interface BaseJobRepository
{
    public function save(Job $job): Job;
    public function find(Integers $id): Job;
    public function delete(Integers $id): Job;
}
