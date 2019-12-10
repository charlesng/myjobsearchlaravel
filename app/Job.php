<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    protected $table = 'jobs';
    protected $fillable = [
        'title', 'description', 'company_name', 'location', 'salary', 'salary_period', 'img_src'
    ];
    public $timestamps = true;
}
