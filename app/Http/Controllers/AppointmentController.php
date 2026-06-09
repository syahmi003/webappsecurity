<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    // 1. AUTHORIZATION — all methods require authenticated user (enforced in routes)

    public function index()
    {
        $appointments = Appointment::orderBy('appointment_id', 'asc')->get();
        return view('add-appointment', compact('appointments'));
    }

    public function create()
    {
        return view('create-appointment');
    }

    public function store(Request $request)
    {
        // 2. INPUT VALIDATION — complete rules for all fields
        $validated = $request->validate([
            'appointment_id'   => 'required|string|max:50|unique:appointments,appointment_id',
            'patient_id'       => 'required|string|max:50',
            'doctor_id'        => 'required|string|max:50',
            'appointment_date' => 'required|date|after_or_equal:today',  // cannot book in the past
            'appointment_time' => 'required|date_format:H:i',
        ]);

        // 3. DATABASE SECURITY — use only validated data
        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('show-appointment', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('edit-appointment', compact('appointment'));
    }

    public function update(Request $request, $id)
    {
        // 4. INPUT VALIDATION — original had broken validate() call (no rules at all)
        $validated = $request->validate([
            'patient_id'       => 'required|string|max:50',
            'doctor_id'        => 'required|string|max:50',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy($id)
    {
        // 5. Fixed — original passed undefined $id to delete()
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
