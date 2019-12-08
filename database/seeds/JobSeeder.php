<?php

use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert(
            array(
                'title' => 'Internship for software engineering',
                'description' => 'Find someone for internship',
                'company_name' => 'JobVector'
            )
        );
    }
}
