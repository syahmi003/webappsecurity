<?php

namespace App\Http\Controllers;

use App\Models\Medical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalController extends Controller
{
    // 1. AUTHORIZATION — all methods require authenticated user (enforced in routes)

    public function index()
    {
        $medicals = DB::table('medical')->orderBy('updated_at', 'asc')->get();
        return view('medical', ['medicals' => $medicals]);
    }

    public function view_more()
    {
        $medicals = DB::table('medical')->orderBy('updated_at', 'asc')->get();
        return view('view-medical', compact('medicals'));
    }

    public function create()
    {
        return view('add-medical');
    }

    public function store(Request $request)
    {
        // 2. INPUT VALIDATION — added max lengths and stricter rules
        $request->validate([
            'record_id'      => 'required|string|max:50|unique:medical,record_id|alpha_num',
            'patient_name'   => 'required|string|max:255',
            'diagnosis'      => 'required|string|max:1000',
            'treatment'      => 'required|string|max:1000',
            'doctor'         => 'required|string|max:255',
            'date_of_record' => 'required|date|before_or_equal:today', // cannot be a future date
        ]);

        // 3. DATABASE SECURITY — use only() not all()
        Medical::create($request->only([
            'record_id', 'patient_name', 'diagnosis',
            'treatment', 'doctor', 'date_of_record',
        ]));

        return redirect()->route('medical.view_more')->with('success', 'Medical record created successfully.');
    }

    public function show(string $id)
    {
        $medical = Medical::findOrFail($id);
        return view('view-medical', compact('medical'));
    }

    public function edit(string $id)
    {
        $medical = Medical::findOrFail($id);
        return view('edit-medical', compact('medical'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'patient_name'   => 'required|string|max:255',
            'diagnosis'      => 'required|string|max:1000',
            'treatment'      => 'required|string|max:1000',
            'doctor'         => 'required|string|max:255',
            'date_of_record' => 'required|date|before_or_equal:today',
        ]);

        $medical = Medical::findOrFail($id);
        $medical->update($request->only([
            'patient_name', 'diagnosis', 'treatment', 'doctor', 'date_of_record',
        ]));

        return redirect()->route('medical.view_more')->with('success', 'Medical record updated successfully');
    }

    public function destroy(string $id)
    {
        $medical = Medical::findOrFail($id);
        $medical->delete();
        return redirect()->route('medical.view_more')->with('success', 'Medical record deleted successfully');
    }
}
