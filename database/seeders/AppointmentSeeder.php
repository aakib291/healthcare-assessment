<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        Appointment::create([
            'doctor_id' => 1,
            'patient_id' => 1,
            'appointment_date' => Carbon::now()->addDays(3),
            'status' => 'confirmed',
            'notes' => 'Seeded appointment',
        ]);
    }
}
