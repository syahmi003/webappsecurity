@extends('master.layout')
@section('title', 'Edit Invoice')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>

    <style>

        .header {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 10px;
            border-bottom: 1px solid #ccc;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 36px;
        }
        .contact-info {
            text-align: left;
            font-size: 5px;
        }
        .contact-info p {
            margin: 0;
            font-size: 12px;
        }

        /* Form Sections */
        .form-section {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
            gap: 20px;
        }

        .form-group {
            flex: 1 1 calc(33% - 20px);
            min-width: 200px;
        }

        label {
            font-size: 14px;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Item Table */
        .item-section {
            margin-bottom: 20px;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .item-table th, .item-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .item-table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .input-table {
            width: 100%;
            border: none;
            padding: 8px;
            font-size: 14px;
        }

        .input-table:focus {
            outline: none;
            border: 1px solid #007bff;
        }

        /* Buttons */
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: #dc3545;
        }

        /* Add/Remove Buttons */
        .add-row-btn, .remove-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-row-btn:hover {
            background-color: #007bff;
        }
        .item-section {
    margin-bottom: 20px;
    text-align: center; /* Center the content inside item section */
}

.add-row-btn {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block; /* Ensure it doesn't take up the whole width */
}

.add-row-btn:hover {
    background-color: #007bff;
}


        .remove-btn {
            background-color: #dc3545;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }

        /* Summary Section */
        .summary {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        /* Centering the action buttons */
        .form-actions {
            display: flex;
            justify-content: center;
            gap: 20px; /* Optional: space between the buttons */
            margin-top: 20px; /* Optional: space above the buttons */
        }

        .add-row-btn {
            background-color: #007bff;
            color: #fff;
        }

        .add-row-btn:hover {
            background-color: #007bff;
        }

        .btn-primary {
            background-color: #28a745;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #dc3545;
        }
    </style>

</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Medical Logo" class="h-16">
            </a>
            <span>Medical.</span>
        </div>
        <div class="contact-info">
            <p><strong>Hospital Kuala Lumpur</strong></p>
            <p>No. 123, Jalan Kesihatan, 50450 Kuala Lumpur, Malaysia</p>
            <p>+60 3-1234-5678</p>
            <p>billinghkl@moh.gov.my</p>
        </div>
    </div>

    <div class="container">
        <h2 class="section-tittle">Edit Invoice</h2>

        <!-- Error Display -->
        @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Section -->
        <form id="invoice-form" action="{{ route('invoice.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <!-- Row 1: Dates -->
                <div class="form-group">
                    <label for="bill_date">Bill Date</label>
                    <input type="date" id="bill_date" name="bill_date" class="input" value="{{ old('bill_date', $invoice->bill_date) }}" required>
                </div>
                <div class="form-group">
                    <label for="delivery_date">Delivery Date</label>
                    <input type="date" id="delivery_date" name="delivery_date" class="input" value="{{ old('delivery_date', $invoice->delivery_date) }}" required>
                </div>
                <div class="form-group">
                    <label for="payment_deadline">Payment Deadline</label>
                    <input type="date" id="payment_deadline" name="payment_deadline" class="input" value="{{ old('payment_deadline', $invoice->payment_deadline) }}" required>
                </div>
            </div>

            <!-- Row 2: Patient and Contact Info -->
            <div class="form-section">
                <div class="form-group">
                    <label for="patient_name">Patient Name</label>
                    <input type="text" id="patient_name" name="patient_name" class="input" value="{{ old('patient_name', $invoice->patient_name) }}" required>
                </div>
                <div class="form-group">
                    <label for="billing_address">Billing Address</label>
                    <input type="text" id="billing_address" name="billing_address" class="input" value="{{ old('billing_address', $invoice->billing_address) }}" required>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group">
                    <label for="contact_info">Contact Number</label>
                    <input type="text" id="contact_info" name="contact_info" class="input" value="{{ old('contact_info', $invoice->contact_info) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="input" value="{{ old('email', $invoice->email) }}" required>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label for="invoice_id">Invoice ID</label>
                    <input type="text" id="invoice_id" name="invoice_id" class="input" value="{{ old('invoice_id', $invoice->invoice_id) }}" required>
                </div>
            </div>

            <!-- Item Table -->
            <div class="item-section">
                <table class="item-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price (MYR)</th>
                            <th>VAT (6%)</th>
                            <th>Final Amount (MYR)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-items">
                        @if(!empty($invoice->items) && $invoice->items->count())
                            @foreach($invoice->items as $item)
                            <tr>
                                <td><input type="text" name="description[]" class="input-table" value="{{ $item->description }}" /></td>
                                <td><input type="number" name="quantity[]" class="input-table" value="{{ $item->quantity }}" /></td>
                                <td><input type="number" step="0.01" name="price[]" class="input-table" value="{{ $item->price }}" /></td>
                                <td><input type="number" step="0.01" name="vat[]" class="input-table" value="6" readonly /></td>
                                <td><input type="number" step="0.01" name="final_amount[]" class="input-table" value="{{ $item->final_amount }}" /></td>
                                <td>
                                    <button type="button" class="remove-btn" onclick="removeRow(this)">Remove</button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No items found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <button type="button" class="add-row-btn" onclick="addRow()">Add Row</button>
            </div>

            <!-- Summary Section -->
            <div class="form-section summary">
                <div class="form-group">
                    <label for="subtotal">Subtotal</label>
                    <input type="number" step="0.01" id="subtotal" name="subtotal" class="input" readonly>
                </div>
                <div class="form-group">
                    <label for="vat-total">VAT Total</label>
                    <input type="number" step="0.01" id="vat-total" name="vat_total" class="input" readonly>
                </div>
                <div class="form-group">
                    <label for="total-amount">Total Amount</label>
                    <input type="number" step="0.01" id="total-amount" name="total_amount" class="input" readonly>
                </div>
                <div class="form-group">
                    <label for="payment_status">Payment Status</label>
                    <select id="payment_status" name="payment_status" class="input">
                        <option value="PAID">PAID</option>
                        <option value="UNPAID">UNPAID</option>
                    </select>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">Update Invoice</button>
                <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('billing-list') }}'">Cancel</button>
            </div>
        </form>
    </div>
</body>

</html>


        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calculate final amount for a row and update totals
            function calculateFinalAmount(element) {
                const row = element.closest('tr');
                const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
                const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
                const vatAmount = quantity * price * 0.06;

                const baseAmount = quantity * price;
                row.querySelector('input[name="final_amount[]"]').value = (baseAmount + vatAmount).toFixed(2);
                updateSummary();
            }

            // Update summary totals
            function updateSummary() {
                const rows = document.querySelectorAll('#invoice-items tr');
                let subtotal = 0;
                let vatTotal = 0;

                rows.forEach(row => {
                    const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
                    const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
                    const baseAmount = quantity * price;
                    const vatAmount = baseAmount * 0.06;

                    subtotal += baseAmount;
                    vatTotal += vatAmount;
                });

                const totalAmount = subtotal + vatTotal;

                // Update the summary fields
                document.getElementById('subtotal').value = subtotal.toFixed(2);
                document.getElementById('vat-total').value = vatTotal.toFixed(2);
                document.getElementById('total-amount').value = totalAmount.toFixed(2);
            }

            // Add a new row
            // function addRow() {
            //     const table = document.getElementById('invoice-items');
            //     const row = document.createElement('tr');
            //     row.innerHTML = `
            //         <td><input type="text" name="description[]" class="form-control" placeholder="Enter treatment/service" required></td>
            //         <td><input type="number" name="quantity[]" class="form-control" value="0" required></td>
            //         <td><input type="number" step="0.01" name="price[]" class="form-control" value="0.00" required></td>
            //         <td><input type="number" step="0.01" name="vat[]" class="form-control" value="6" readonly></td>
            //         <td><input type="number" step="0.01" name="final_amount[]" class="form-control" value="0.00" readonly></td>
            //         <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
            //     `;

            //     // Add event listeners to the new row's inputs
            //     const inputs = row.querySelectorAll('input[name="quantity[]"], input[name="price[]"]');
            //     inputs.forEach(input => {
            //         input.addEventListener('input', function() {
            //             calculateFinalAmount(this);
            //         });
            //     });

            //     table.appendChild(row);
            //     updateSummary();
            // }

            function addRow() {
        const table = document.getElementById('invoice-items');
        const row = document.createElement('tr');
        row.innerHTML = `
        <td><input type="text" name="description[]" class="form-control" placeholder="Enter treatment/service" required></td>
        <td><input type="number" name="quantity[]" class="form-control text-center" value="0" required oninput="calculateFinalAmount(this)"></td>
        <td><input type="number" step="0.01" name="price[]" class="form-control text-center" value="0.00" required oninput="calculateFinalAmount(this)"></td>
        <td><input type="number" step="0.01" name="vat[]" class="form-control text-center" value="6" readonly></td>
        <td><input type="number" step="0.01" name="final_amount[]" class="form-control text-center" value="0.00" readonly></td>
        <td><button type="button" class="remove-btn" onclick="removeRow(this)">Remove</button></td>
    `;
    table.appendChild(row);
    }

            // Remove a row
            function removeRow(button) {
                const row = button.closest('tr');
                row.remove();
                updateSummary();
            }

            // Add event listeners to existing rows
            document.querySelectorAll('#invoice-items tr').forEach(row => {
                const inputs = row.querySelectorAll('input[name="quantity[]"], input[name="price[]"]');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        calculateFinalAmount(this);
                    });
                });
            });

            // Make functions globally available
            window.addRow = addRow;
            window.removeRow = removeRow;
            window.calculateFinalAmount = calculateFinalAmount;
            window.updateSummary = updateSummary;

            // Calculate initial totals
            updateSummary();

            // Form submission handler
            document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('invoice-form');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Append hidden input for invoice items
        const items = [];
        document.querySelectorAll('#invoice-items tr').forEach(row => {
            items.push({
                description: row.querySelector('input[name="description[]"]').value,
                quantity: row.querySelector('input[name="quantity[]"]').value,
                price: row.querySelector('input[name="price[]"]').value,
                vat: 6,
                final_amount: row.querySelector('input[name="final_amount[]"]').value
            });
        });

        const itemsInput = document.createElement('input');
        itemsInput.type = 'hidden';
        itemsInput.name = 'items';
        itemsInput.value = JSON.stringify(items);
        form.appendChild(itemsInput);

        form.submit(); // Call the native submit method
        });
    });
    });
        </script>

</div>
@endsection