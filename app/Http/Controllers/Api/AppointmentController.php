<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use App\Http\Resources\AppointmentResource;

class AppointmentController extends Controller
{
    //Store
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        // Prevent double booking
        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Doctor already booked for this time slot'
            ], 409);
        }

        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return response()->json([
            'message' => 'Appointment booked successfully',
            'data' => new AppointmentResource(
                $appointment->load(['doctor', 'patient'])
            ),
        ], 201);
    }

    public function show($id)
    {
        $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($id);

        return new AppointmentResource($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        //Cancel rule: 24 hours before
        if ($request->status === 'cancelled') {
            if (Carbon::now()->diffInHours($appointment->appointment_date, false) < 24) {
                return response()->json([
                    'message' => 'Appointments can only be cancelled 24 hours before'
                ], 403);
            }
        }

        $appointment->update($request->only('status', 'notes'));

        return response()->json([
            'message' => 'Appointment updated',
            'data' => new AppointmentResource(
                $appointment->load(['doctor', 'patient'])
            ),
        ]);
    }


    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (Carbon::now()->diffInHours($appointment->appointment_date, false) < 24) {
            return response()->json([
                'message' => 'Cannot cancel appointment within 24 hours'
            ], 403);
        }

        $appointment->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Appointment cancelled'
        ]);
    }
}
