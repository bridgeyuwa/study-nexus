<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use Faker\Factory as Faker;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();
        $institutionIds = ['aau','bsu','makurdi','abu','aaau']; // Example array of institution IDs

        for ($i = 0; $i < 50; $i++) {
            News::create([
                'title' => $faker->sentence,
                'excerpt' => $faker->paragraph,
                'content' => $faker->text(2000),
                'source_url' => $faker->url,
                'institution_id' => $faker->randomElement($institutionIds),
            ]);
        }
    }
}


