<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{
    // 1. AUTHORIZATION — all methods require authenticated user (enforced in routes)

    public function create()
    {
        return view('create-invoice');
    }

    public function index()
    {
        $invoices = Invoice::all();
        return view('billing-list', compact('invoices'));
    }

    public function store(Request $request)
    {
        // 2. INPUT VALIDATION — original had ZERO validation; all fields now validated
        $request->validate([
            'bill_date'        => 'required|date',
            'delivery_date'    => 'required|date|after_or_equal:bill_date',
            'payment_deadline' => 'required|date|after_or_equal:bill_date',
            'invoice_id'       => 'required|string|max:50|unique:invoices,invoice_id',
            'patient_name'     => 'required|string|max:255',
            'billing_address'  => 'required|string|max:500',
            'contact_info'     => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'subtotal'         => 'required|numeric|min:0',
            'vat_total'        => 'required|numeric|min:0',
            'total_amount'     => 'required|numeric|min:0',
            'payment_status'   => 'required|in:Paid,Unpaid,Pending',  // whitelist
            'items'            => 'required|json',                     // must be valid JSON
        ]);

        // 3. DATABASE SECURITY — use only validated/whitelisted fields
        $invoice = Invoice::create($request->only([
            'bill_date', 'delivery_date', 'payment_deadline', 'invoice_id',
            'patient_name', 'billing_address', 'contact_info', 'email',
            'subtotal', 'vat_total', 'total_amount', 'payment_status',
        ]));

        // 4. INPUT VALIDATION — validate each item inside the JSON array
        $items = json_decode($request->items, true);

        if (is_array($items)) {
            foreach ($items as $index => $item) {
                // Validate individual item fields
                $itemValidator = validator($item, [
                    'description'  => 'required|string|max:255',
                    'quantity'     => 'required|integer|min:1',
                    'price'        => 'required|numeric|min:0',
                    'vat'          => 'required|numeric|min:0',
                    'final_amount' => 'required|numeric|min:0',
                ]);

                if ($itemValidator->fails()) {
                    continue; // Skip malformed items instead of crashing
                }

                if (!empty($item['description'])) {
                    InvoiceItem::create([
                        'invoice_id'   => $invoice->id,
                        'description'  => $item['description'],
                        'quantity'     => $item['quantity'],
                        'price'        => $item['price'],
                        'vat'          => $item['vat'],
                        'final_amount' => $item['final_amount'],
                    ]);
                }
            }
        }

        return redirect()->route('billing-list')->with('success', 'Invoice created successfully');
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('show-invoice', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        return view('edit-invoice', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        // 5. INPUT VALIDATION — complete validation including header fields
        $request->validate([
            'bill_date'        => 'required|date',
            'delivery_date'    => 'required|date|after_or_equal:bill_date',
            'payment_deadline' => 'required|date|after_or_equal:bill_date',
            'patient_name'     => 'required|string|max:255',
            'billing_address'  => 'required|string|max:500',
            'contact_info'     => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'subtotal'         => 'required|numeric|min:0',
            'vat_total'        => 'required|numeric|min:0',
            'total_amount'     => 'required|numeric|min:0',
            'payment_status'   => 'required|in:Paid,Unpaid,Pending',
            'description'      => 'required|array|min:1',
            'description.*'    => 'required|string|max:255',
            'quantity'         => 'required|array',
            'quantity.*'       => 'required|integer|min:1',
            'price'            => 'required|array',
            'price.*'          => 'required|numeric|min:0',
            'vat'              => 'nullable|array',
            'vat.*'            => 'nullable|numeric|min:0',
            'final_amount'     => 'required|array',
            'final_amount.*'   => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::findOrFail($id);

        $invoice->update($request->only([
            'bill_date', 'delivery_date', 'payment_deadline', 'patient_name',
            'billing_address', 'contact_info', 'email',
            'subtotal', 'vat_total', 'total_amount', 'payment_status',
        ]));

        $invoice->items()->delete();

        foreach ($request->description as $index => $desc) {
            InvoiceItem::create([
                'invoice_id'   => $invoice->id,
                'description'  => $desc,
                'quantity'     => $request->quantity[$index],
                'price'        => $request->price[$index],
                'vat'          => $request->vat[$index] ?? 0,
                'final_amount' => $request->final_amount[$index],
            ]);
        }

        return redirect()->route('billing-list')->with('success', 'Invoice updated successfully!');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->items()->delete();
        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice deleted successfully!',
        ]);
    }
}
