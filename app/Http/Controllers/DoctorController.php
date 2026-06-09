<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    // 1. AUTHORIZATION — all methods require authenticated user (enforced in routes)

    public function index()
    {
        $doctors = DB::table('doctors')->orderBy('doctor_id', 'asc')->get();
        return view('doctor', ['doctors' => $doctors]);
    }

    public function create()
    {
        return view('add-doctor');
    }

    public function store(Request $request)
    {
        // 2. INPUT VALIDATION — added max lengths, regex, unique constraint
        $request->validate([
            'doctor_id'     => 'required|string|max:20|unique:doctors,doctor_id|alpha_num',
            'doctor_name'   => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'department'    => 'required|string|max:100',
            'email_address' => 'required|email|max:255|unique:doctors,email_address',
            'schedule'      => 'required|string|max:255',
            'contact_no'    => 'required|string|max:15|regex:/^[0-9\+\-\s]+$/',
        ]);

        // 3. DATABASE SECURITY — use only() not all()
        Doctor::create($request->only([
            'doctor_id', 'doctor_name', 'department',
            'email_address', 'schedule', 'contact_no',
        ]));

        return redirect()->route('doctor')->with('success', 'Doctor created successfully.');
    }

    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctor', compact('doctor'));
    }

    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);  // findOrFail instead of find — returns 404 if not found
        return view('edit-doctor', compact('doctor'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'doctor_name'   => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'department'    => 'required|string|max:100',
            'email_address' => 'required|email|max:255|unique:doctors,email_address,' . $id,
            'schedule'      => 'required|string|max:255',
            'contact_no'    => 'required|string|max:15|regex:/^[0-9\+\-\s]+$/',
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->only([
            'doctor_name', 'department', 'email_address', 'schedule', 'contact_no',
        ]));

        return redirect()->route('doctor')->with('success', 'Doctor updated successfully');
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctor')->with('success', 'Doctor deleted successfully');
    }
}
