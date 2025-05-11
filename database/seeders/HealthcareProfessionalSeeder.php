<?php

namespace Database\Seeders;

use App\Models\HealthcareProfessional;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class HealthcareProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            Schema::disableForeignKeyConstraints();
            HealthcareProfessional::truncate();
            Schema::enableForeignKeyConstraints();

            $currentDateTime = Carbon::now();

            $professionals = [
                [
                    'name' => 'Dr. Smith',
                    'speciality' => 'Cardiology',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'Dr. Johnson',
                    'speciality' => 'Pediatrics',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'Dr. Williams',
                    'speciality' => 'Dermatology',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'Dr. Brown',
                    'speciality' => 'Orthopedics',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'Dr. Garcia',
                    'speciality' => 'Oncology',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'Dr. Martinez',
                    'speciality' => 'Gynecology',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'Dr. Anderson',
                    'speciality' => 'Psychiatry',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'Dr. Taylor',
                    'speciality' => 'Ophthalmology',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
                [
                    'name' => 'Dr. Thomas',
                    'speciality' => 'Endocrinology',
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ],
            ];

            HealthcareProfessional::insert($professionals);
        } catch (\Exception $e) {
            $this->command->error('Error seeding healthcare professionals: '.$e->getMessage());
        }
    }
}
