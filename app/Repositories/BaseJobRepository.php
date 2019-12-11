<?php

namespace App\Repositories;

use App\Job;

interface BaseJobRepository
{
    public function save(Job $job): Job;
    public function find(int $id): Job;
    public function delete(int $id): Job;
    public function paginate();
}
