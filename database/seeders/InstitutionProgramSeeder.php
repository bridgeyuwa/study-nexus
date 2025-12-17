<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InstitutionProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = public_path('files.json');

        if (!File::exists($filePath)) {
            $this->command->error("The file files.json was not found in the public directory.");
            return;
        }

        $fileContent = File::get($filePath);
        $data = json_decode($fileContent);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error("Error decoding JSON from files.json: " . json_last_error_msg());
            return;
        }

        foreach ($data as &$obj) {
            if (isset($obj->institutions_list)) {
                $institution = $obj->institutions_list;
                unset($obj->institutions_list);
                $obj = (object) array_merge(['institutions_list' => $institution], (array) $obj);
            }
        }

        $allSql = '';
        foreach ($data as &$obj) {
            if (isset($obj->institutions_list) && isset($obj->title)) {
                $institution = $obj->institutions_list;
                $program = $obj->title;

                unset($obj->institutions_list);
                unset($obj->title);

                $encodedObj = json_encode($obj);
                $escapedData = addslashes($encodedObj);

                //prepare SQL
                $sql = "INSERT INTO institution_program (institution_id, program_id, level_id, requirement) VALUES ('$institution','$program',1,'$escapedData');";

                $allSql .= $sql . PHP_EOL;
            }
        }

        if (!empty($allSql)) {
            DB::unprepared($allSql);
            $this->command->info('Institution program data seeded successfully.');
        } else {
            $this->command->info('No new institution program data to seed.');
        }
    }
}
