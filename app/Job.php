<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * @var string
     */
    protected $table = 'jobs';
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'company_name', 'location', 'salary', 'salary_period', 'img_src'
    ];
    /**
     * @var bool
     */
    public $timestamps = true;
}
