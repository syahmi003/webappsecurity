@extends('master.layout')
@section('content')

<style>
    .action-btn {
        width: 120px;
        font-size: 14px;
        padding: 8px;
    }

    .cancel-btn {
          background-color: red !important;
         border-color: red !important;
         color: white !important;
        border-radius: 11px;
         width: 120px;
        font-size: 14px;
        padding: 8px;
        cursor: pointer;
     }

    .danger-btn {
    background-color: red !important;
    border-color: red !important;
    color: white !important;
    border-radius: 11px;
    width: 120px;
    font-size: 14px;
    padding: 8px;
    cursor: pointer;
    }

    .text-center .btn-secondary {
        display: inline-block;
        margin: 0 auto;
    }
</style>

<main>
    <!-- Hero Section -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 text-center">
                            <h2>Invoice</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <div class="section-padding30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-tittle text-center mb-4">
                        <h2>New Invoice</h2>
                    </div>
                </div>
            </div>

            <form id="invoice-form" action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="bill_date">Bill Date</label>
                        <input type="date" name="bill_date" class="form-control" id="bill_date" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="delivery_date">Delivery Date</label>
                        <input type="date" name="delivery_date" class="form-control" id="delivery_date" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="payment_deadline">Due Date</label>
                        <input type="date" name="payment_deadline" class="form-control" id="payment_deadline" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="invoice_id">Invoice ID</label>
                        <input type="text" name="invoice_id" class="form-control" id="invoice_id" placeholder="e.g., INV1995" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="patient_name">Patient Name</label>
                        <input type="text" name="patient_name" class="form-control" id="patient_name" placeholder="Enter patient's full name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="billing_address">Billing Address</label>
                        <input type="text" name="billing_address" class="form-control" id="billing_address" placeholder="Enter complete address" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact_info">Contact Number</label>
                        <input type="text" name="contact_info" class="form-control" id="contact_info" placeholder="Enter phone number" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email address" required>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price (MYR)</th>
                                <th>VAT (%)</th>
                                <th>Total (MYR)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-items">
                            <tr>
                                <td><input type="text" name="description[]" class="form-control" required></td>
                                <td><input type="number" name="quantity[]" class="form-control text-center" required oninput="calculateFinalAmount(this)"></td>
                                <td><input type="number" step="0.01" name="price[]" class="form-control text-center" required oninput="calculateFinalAmount(this)"></td>
                                <td><input type="number" step="0.01" name="vat[]" class="form-control text-center" value="6" readonly></td>
                                <td><input type="number" step="0.01" name="final_amount[]" class="form-control text-center" readonly></td>
                                <td><button type="button" class="danger-btn btn-sm action-btn" onclick="removeRow(this)">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-secondary action-btn" onclick="addRow()">Add Item</button>
                </div>

                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="form-group">
                            <label>Subtotal:</label>
                            <input type="number" step="0.01" id="subtotal" name="subtotal" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>VAT Total:</label>
                            <input type="number" step="0.01" id="vat-total" name="vat_total" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Total Amount:</label>
                            <input type="number" step="0.01" id="total-amount" name="total_amount" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Payment Status:</label>
                            <select name="payment_status" class="form-control">
                                <option value="PAID">PAID</option>
                                <option value="UNPAID">UNPAID</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary action-btn">Save Invoice</button>
                    <a href="{{ route('billing-list') }}" class="btn btn-danger action-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.getElementById('bill_date').addEventListener('change', function() {
    const billDate = new Date(this.value);
    const deadlineDate = new Date(billDate);
    deadlineDate.setDate(deadlineDate.getDate() + 15); // Add 15 days

    // Format the date as YYYY-MM-DD for the input
    const formattedDate = deadlineDate.toISOString().split('T')[0];
    document.getElementById('payment_deadline').value = formattedDate;
});
    document.getElementById('invoice-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const items = [];
        document.querySelectorAll('#invoice-items tr').forEach(row => {
            items.push({
                description: row.querySelector('input[name="description[]"]').value,
                quantity: row.querySelector('input[name="quantity[]"]').value,
                price: row.querySelector('input[name="price[]"]').value,
                vat: row.querySelector('input[name="vat[]"]').value,
                final_amount: row.querySelector('input[name="final_amount[]"]').value
            });
        });
        const itemsInput = document.createElement('input');
        itemsInput.type = 'hidden';
        itemsInput.name = 'items';
        itemsInput.value = JSON.stringify(items);
        this.appendChild(itemsInput);
        this.submit();
    });

    function calculateFinalAmount(element) {
    const row = element.closest('tr');
    const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
    const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
    const vat = 6; // Fixed VAT percentage (6%)

    const amountBeforeVAT = quantity * price;

    const vatAmount = amountBeforeVAT * (vat / 100);

    const finalAmount = amountBeforeVAT + vatAmount;

    row.querySelector('input[name="final_amount[]"]').value = finalAmount.toFixed(2);

    updateSummary();
    }


    function updateSummary() {
    const rows = document.querySelectorAll('#invoice-items tr');
    let subtotal = 0;
    let vatTotal = 0;
    let totalAmount = 0;

    rows.forEach(row => {
        const finalAmount = parseFloat(row.querySelector('input[name="final_amount[]"]').value) || 0;
        const amountBeforeVAT = finalAmount / 1.06; 
        const vatAmount = finalAmount - amountBeforeVAT; 

        subtotal += amountBeforeVAT;  
        vatTotal += vatAmount;        
    });

    totalAmount = subtotal + vatTotal; 

    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('vat-total').value = vatTotal.toFixed(2);
    document.getElementById('total-amount').value = totalAmount.toFixed(2);
    }


    function addRow() {
        const table = document.getElementById('invoice-items');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" name="description[]" class="form-control" placeholder="Enter treatment/service" required></td>
            <td><input type="number" name="quantity[]" class="form-control" value="0" required oninput="calculateFinalAmount(this)"></td>
            <td><input type="number" step="0.01" name="price[]" class="form-control" value="0.00" required oninput="calculateFinalAmount(this)"></td>
            <td><input type="number" step="0.01" name="vat[]" class="form-control" value="0.00" oninput="calculateFinalAmount(this)"></td>
            <td><input type="number" step="0.01" name="final_amount[]" class="form-control" value="0.00" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
        `;
        table.appendChild(row);
    }

    function removeRow(button) {
        const row = button.closest('tr');
        row.remove();
        updateSummary();
    }
</script>

@endsection