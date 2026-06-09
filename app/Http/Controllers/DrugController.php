<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    // 1. AUTHORIZATION — all methods require authenticated user (enforced in routes)

    public function index()
    {
        $drugs = Drug::all();
        return view('pharmacy', compact('drugs'));
    }

    public function create()
    {
        return view('add-drug');
    }

    public function edit($id)
    {
        $drug = Drug::findOrFail($id);
        return view('edit-drug', compact('drug'));
    }

    public function store(Request $request)
    {
        // 2. INPUT VALIDATION — added logical date checks
        $request->validate([
            'drug_name'        => 'required|string|max:255',
            'manufacture_date' => 'required|date|before:today',
            'expiry_date'      => 'required|date|after:manufacture_date', // expiry must be after manufacture
            'price'            => 'required|numeric|min:0',
            'quantity'         => 'required|integer|min:0',
        ]);

        // 3. DATABASE SECURITY — use only() not all()
        Drug::create($request->only([
            'drug_name', 'manufacture_date', 'expiry_date', 'price', 'quantity',
        ]));

        return redirect()->route('pharmacy')->with('success', 'Drug added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'drug_name'        => 'required|string|max:255',
            'manufacture_date' => 'required|date|before:today',
            'expiry_date'      => 'required|date|after:manufacture_date',
            'price'            => 'required|numeric|min:0',
            'quantity'         => 'required|integer|min:0',
        ]);

        $drug = Drug::findOrFail($id);
        $drug->update($validated);

        return redirect()->route('pharmacy')->with('success', 'Drug updated successfully.');
    }

    public function destroy($id)
    {
        $drug = Drug::findOrFail($id);
        $drug->delete();
        return redirect()->route('pharmacy')->with('success', 'Drug deleted successfully.');
    }
}
