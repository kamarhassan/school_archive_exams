<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Throwable;

class stdseed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Path to your JSON file (adjust filename/path if needed)
        $jsonPath = database_path('seeders/data/students.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("JSON file not found at: {$jsonPath}");
            return;
        }

        $json = File::get($jsonPath);
        $students = json_decode($json, true);

        if (empty($students)) {
            $this->command->info("No student data found to seed.");
            return;
        }

        $now = now();
        $formattedData = [];

        // 2. Transform and clean each record
        foreach ($students as $student) {
            // Helper function to trim and convert empty strings to NULL
            $clean = fn($key) => isset($student[$key]) && trim((string)$student[$key]) !== '' 
                ? trim((string)$student[$key]) 
                : null;

            // Date parsing logic (handles month/day/year format safely)
            $dob = null;
            $rawDob = $clean('date_of_birth');

            if ($rawDob) {
                try {
                    // Parse month/day/year format (e.g. "3/12/2010", "9/29/2011")
                    $dob = Carbon::createFromFormat('m/d/Y', $rawDob)->format('Y-m-d');
                } catch (Throwable $e) {
                    try {
                        // Fallback attempt with slash-to-hyphen normalization
                        $dob = Carbon::parse(str_replace('/', '-', $rawDob))->format('Y-m-d');
                    } catch (Throwable $e) {
                        $dob = null; // Set to null if date is completely unparseable
                    }
                }
            }

            $formattedData[] = [
                'unified_number'            => $clean('unified_number'),
                'contact_id'                => $clean('contact_id'),
                'first_name_ar'             => $clean('first_name_ar'),
                'first_name_en'             => $clean('first_name_en'),
                'family_name_ar'            => $clean('family_name_ar'),
                'last_name_en'              => $clean('last_name_en'),
                'previous_grade'            => $clean('previous_grade'),
                'current_grade'             => $clean('current_grade'),
                'previous_result'           => $clean('previous_result'),
                'date_of_birth'             => $dob,
                'place_of_birth'            => $clean('place_of_birth'),
                'gender'                    => $clean('gender'),
                'id_card_type'              => $clean('id_card_type'),
                'id_card_number'            => $clean('id_card_number'),
                'contact_location'          => $clean('contact_location'),
                'nationality'               => $clean('nationality'),
                'father_name_ar'            => $clean('father_name_ar'),
                'father_name_en'            => $clean('father_name_en'),
                'guardian_phone'            => $clean('guardian_phone'),
                'father_work_sector'        => $clean('father_work_sector'),
                'mother_first_name_ar'      => $clean('mother_first_name_ar'),
                'mother_name_en'            => $clean('mother_name_en'),
                'mother_family_name_ar'     => $clean('mother_family_name_ar'),
                'mother_family_name_ar_alt' => $clean('mother_family_name_ar_alt'),
                'mother_family_name_en'     => $clean('mother_family_name_en'),
                'mother_work_sector'        => $clean('mother_work_sector'),
                'mother_nationality'        => $clean('mother_nationality'),
                'created_at'                => $now,
                'updated_at'                => $now,
            ];
        }

        // 3. Bulk insert in chunks of 500 records
        foreach (array_chunk($formattedData, 500) as $chunk) {
            DB::table('student_olds')->insert($chunk);
        }

        $this->command->info('Successfully seeded ' . count($formattedData) . ' records into student_olds.');
    }
}