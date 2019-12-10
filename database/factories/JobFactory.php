<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(5),
        'description' => $faker->text(),
        'company_name' => $faker->text(),
        'img_src' => $faker->text(),
        'salary' => $faker->text(),
        'salary_period' => 'Yearly',
        'location' => $faker->text()
    ];
});
