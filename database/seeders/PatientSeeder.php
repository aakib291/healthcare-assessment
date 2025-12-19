<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        Patient::insert([
            [
                'name' => 'John Doe',
                'email' => 'john@test.com',
                'phone' => '9999999999',
                'date_of_birth' => '1995-01-01',
            ],
            [
                'name' => 'Aisha Khan',
                'email' => 'aisha@test.com',
                'phone' => '8888888888',
                'date_of_birth' => '1998-05-12',
            ],
        ]);
    }
}
