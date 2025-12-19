<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        Doctor::insert([
            [
                'name' => 'Dr Smith',
                'specialization' => 'Cardiology',
                'availability_schedule' => json_encode(['09:00-12:00','14:00-18:00']),
            ],
            [
                'name' => 'Dr Adams',
                'specialization' => 'Orthopedic',
                'availability_schedule' => json_encode(['10:00-13:00']),
            ],
            [
                'name' => 'Dr Khan',
                'specialization' => 'Dermatology',
                'availability_schedule' => json_encode(['11:00-15:00']),
            ],
        ]);
    }
}
