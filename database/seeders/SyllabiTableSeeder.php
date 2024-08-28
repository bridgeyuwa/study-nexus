<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Syllabus;
use Faker\Factory as Faker;

class SyllabiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $exambodyIds = [1,2,3]; // Example array of institution IDs


        foreach($exambodyIds as $exambodyId){
			
			for ($i = 1; $i < 7; $i++) {
				Syllabus::create([
					'name' => $faker->name,
					'exam_body_id' => $exambodyId,
					'subject_id' => $i,
					'url' => $faker->url,
					'description' => $faker->sentence,
				
				]);
			}
		
		}
		
    }
}
