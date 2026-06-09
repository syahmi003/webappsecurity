<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // 1. AUTHORIZATION — all methods require authenticated user (set in routes)

    public function index()
    {
        $patients = Patient::all();
        return view('patient', compact('patients'));
    }

    public function create()
    {
        return view('add-patient');
    }

    public function store(Request $request)
    {
        // 2. INPUT VALIDATION — server-side validation on every field
        $request->validate([
            'patient_id'    => 'required|string|max:20|unique:patients,patient_id|alpha_num',
            'first_name'    => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'last_name'     => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'email'         => 'required|email|max:255|unique:patients,email',
            'phone_number'  => 'required|string|max:15|regex:/^[0-9\+\-\s]+$/',
            'address'       => 'required|string|max:500',
            'gender'        => 'required|in:Male,Female',          // whitelist only valid values
            'date_of_birth' => 'required|date|before:today',       // must be a past date
        ]);

        // 3. DATABASE SECURITY — use only validated data (not $request->all())
        Patient::create($request->only([
            'patient_id', 'first_name', 'last_name',
            'email', 'phone_number', 'address', 'gender', 'date_of_birth',
        ]));

        return redirect()->route('patients.index')->with('success', 'Patient added successfully!');
    }

    public function show($id)
    {
        // 4. AUTHORIZATION — only return the record, not raw model dump
        $patient = Patient::findOrFail($id);
        return view('patient', compact('patient'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('edit-patient', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        // 5. INPUT VALIDATION — original code had NO validation on update
        $request->validate([
            'first_name'    => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'last_name'     => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'email'         => 'required|email|max:255|unique:patients,email,' . $id,
            'phone_number'  => 'required|string|max:15|regex:/^[0-9\+\-\s]+$/',
            'address'       => 'required|string|max:500',
            'gender'        => 'required|in:Male,Female',
            'date_of_birth' => 'required|date|before:today',
        ]);

        $patient = Patient::findOrFail($id);

        // 6. DATABASE SECURITY — use only() not all() to prevent mass-assignment
        $patient->update($request->only([
            'first_name', 'last_name', 'email',
            'phone_number', 'address', 'gender', 'date_of_birth',
        ]));

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully!');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully!');
    }

    public function search(Request $request)
    {
        // 7. INPUT VALIDATION — sanitize search input, limit length
        $request->validate([
            'query' => 'required|string|max:100',
        ]);

        $query = $request->input('query');

        // 8. DATABASE SECURITY — Eloquent uses parameterized queries automatically (no raw SQL)
        $patients = Patient::where('patient_name', 'LIKE', '%' . $query . '%')->get();

        return view('patient', compact('patients'));
    }
}
