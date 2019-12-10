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
            [
                [
                    "title" => "Senior Product Designer",
                    "company_name" => "Google Inc.",
                    "img_src" => "https://avatars0.githubusercontent.com/u/1342004?s=400&v=4",
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                    "location" => "Mt. view, California",
                    "salary" => "$200k - $280k",
                    "salary_period" => "Yearly"
                ],
                [
                    "title" => "Senior UI/Ux Designer",
                    "company_name" => "Facebook",
                    "img_src" => "https://clipground.com/images/official-facebook-logo-png-9.png",
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                    "location" => "Menlo Park, California",
                    "salary" => "$150k - 170k",
                    "salary_period" => "Yearly"
                ], [

                    "title" => "Product Designer",
                    "company_name" => "Apple Inc.",
                    "img_src" => "http://simpleicon.com/wp-content/uploads/apple-256x256.png",
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                    "location" => "Cupertino, California",
                    "salary" => "$250k - 320k ",
                    "salary_period" => "Yearly"
                ], [

                    "title" => "Head of Design",
                    "company_name" => "Spotify",
                    "img_src" => "https://developer.spotify.com/assets/branding-guidelines/icon1@2x.png",
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                    "location" => "Manhatten, New York",
                    "salary" => "$340k - 400k",
                    "salary_period" => "Yearly"
                ], [

                    "title" => "Graphic Designer",
                    "company_name" => "Tinder",
                    "img_src" => "https://styles.redditmedia.com/t5_2w7mz/styles/communityIcon_jmyuhs81jl211.png",
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                    "location" => "Dallas,Texas",
                    "salary" => "$120k - 170k",
                    "salary_period" => "Yearly"
                ], [

                    "title" => "Seinor UI Designer",
                    "company_name" => "Dropbox",
                    "img_src" => "https://cdn4.iconfinder.com/data/icons/free-colorful-icons/360/dropbox.png",
                    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                    "location" => "Dallas,Texas",
                    "salary" => "$150k - 200k",
                    "salary_period" => "Yearly"
                ]
            ]
        );
    }
}
