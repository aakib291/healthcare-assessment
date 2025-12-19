<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function available(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'specialization' => 'nullable|string',
            'sort' => 'nullable|in:name,specialization',
        ]);

        $dateTime = $request->date;

        // Doctors already booked at this time
        $bookedDoctorIds = Appointment::where('appointment_date', $dateTime)
            ->whereIn('status', ['pending','confirmed'])
            ->pluck('doctor_id');

        // Get available doctors
        $doctors = Doctor::whereNotIn('id', $bookedDoctorIds);

        // Filter by specialization
        if ($request->specialization) {
            $doctors->where('specialization', $request->specialization);
        }

        // Sorting
        if ($request->sort) {
            $doctors->orderBy($request->sort);
        }

        return DoctorResource::collection($doctors->get());
    }
}
