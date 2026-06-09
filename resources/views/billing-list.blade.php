@extends('master.layout')
@section('content')

<!DOCTYPE html>
<main>
    <!-- Hero Section -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 text-center">
                            <h2>Billing List</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Billing Section -->
    <div class="team-area section-padding30">
        <div class="container">
            <!-- Section Title -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">
                        <span>Financial Records</span>
                        <h2>Billing Management</h2>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="billing-content">
                <table class="table" style="font-size: 18px;">
                    <thead class="table-gray">
                        <tr>
                            <th>No.</th>
                            <th>Invoice ID</th>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Total Amount</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        @php
                            $descriptions = json_decode($invoice->description, true);
                            $quantities = json_decode($invoice->quantity, true);
                            $prices = json_decode($invoice->price, true);
                            $vats = json_decode($invoice->vat, true);
                            $finalAmounts = json_decode($invoice->final_amount, true);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoice->invoice_id }}</td>
                            <td>{{ $invoice->bill_date }}</td>
                            <td>{{ $invoice->patient_name }}</td>
                            <td>MYR {{ number_format($invoice->total_amount, 2) }}</td>
                            <td>
                                <span class="{{ $invoice->payment_status === 'PAID' ? 'status-paid' : 'status-unpaid' }}">
                                    {{ $invoice->payment_status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('invoice.show', $invoice->id) }}" class="text-info" title="View Invoice">👁</a>
                                <a href="{{ route('invoice.edit', $invoice->id) }}" class="text-info" title="Edit Invoice">✏</a>
                                <a href="#" class="text-danger delete-invoice" data-id="{{ $invoice->id }}" title="Delete Invoice">🗑</a>
                          
                                <form id="delete-form-{{ $invoice->id }}" action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="button-container text-right">
                    <a href="{{ route('create-invoice') }}" class="btn btn-primary">Add new billing</a>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Hero Section Styles */
.slider-area2 {
    background-color: #f8f9fa;
    padding: 60px 0;
}

.slider-height2 {
    min-height: 200px;
}

.hero-cap h2 {
    font-size: 40px;
    font-weight: 700;
    color: #333;
}

/* Section Styles */
.section-padding30 {
    padding: 30px 0;
}

.section-tittle {
    text-align: center;
    margin-bottom: 50px;
}

.section-tittle span {
    color: #037ef9;
    font-size: 18px;
    font-weight: 500;
    display: block;
    margin-bottom: 10px;
}

.section-tittle h2 {
    font-size: 36px;
    font-weight: 700;
    color: #333;
}

/* Table Styles */
.table {
    width: 100%;
    margin-bottom: 2rem;
    background-color: #fff;
    border-collapse: collapse;
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    padding: 15px;
    font-weight: 600;
}

.table tbody td {
    padding: 15px;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
}

/* Status Styles */
.status-paid {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
}

.status-unpaid {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
}

/* Button Styles - Keeping Original */
.button-container {
    text-align: center;
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    background-color: rgb(3, 126, 249);
    color: #fff;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    border-radius: 5px;
}

.btn-primary {
    background-color: rgb(3, 126, 249);
}

/* Alert Styles */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

/* Action Links */
.text-info, .text-danger {
    text-decoration: none;
    margin: 0 5px;
}

.text-info:hover, .text-danger:hover {
    opacity: 0.8;
}
</style>

<script>

    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-invoice');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const invoiceId = this.getAttribute('data-id');

            if (confirm('Are you sure you want to delete this invoice?')) {
                // Send AJAX request to delete the invoice
                fetch(/invoice/${invoiceId}, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        row.remove();
                        alert(data.message);
                    } else {
                        alert('Failed to delete the invoice.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the invoice.');
                });
            }
        });
    });
    });


</script>

@endsection