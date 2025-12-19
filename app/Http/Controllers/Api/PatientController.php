<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Patient;

class PatientController extends Controller
{
    public function appointments($id)
    {
        $patient = Patient::findOrFail($id);

        $appointments = $patient->appointments()
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return AppointmentResource::collection($appointments);
    }
}
