<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NewsNewsCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();
        $news = News::all();
        $newsCategories = NewsCategory::all();

        foreach ($news as $newsItem) {
            // Attach random categories to each news item
            $newsItem->newscategories()->attach(
                $newsCategories->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
