@extends('master.layout')
@section('content')

<main>
    <!-- Hero Start -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 text-center">
                            <h2>Edit Drug</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Edit Drug Form -->
    <div class="team-area section-padding30">
        <div class="container">
            <!-- Section Title -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">
                        <span>EDIT DRUG DETAILS</span>
                        <h2>Pharmacy Inventory</h2>
                    </div>
                </div>
            </div>

            <div>
                <h2>Update drug details</h2>
            </div>

            <div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
                <form action="{{ route('update-drug', $drug->id) }}" method="POST" role="form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Drug Name -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="drug_name">Drug Name</label>
                                <input type="text" name="drug_name" class="form-control" id="drug_name" value="{{ $drug->drug_name }}" placeholder="Enter drug name" required>
                            </div>
                        </div>
                        <!-- Manufacture Date -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="manufacture_date">Manufacture Date</label>
                                <input type="date" name="manufacture_date" class="form-control" id="manufacture_date" value="{{ $drug->manufacture_date }}" required>
                            </div>
                        </div>
                        <!-- Expiry Date -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control" id="expiry_date" value="{{ $drug->expiry_date }}" required>
                            </div>
                        </div>
                        <!-- Price -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" id="price" value="{{ $drug->price }}" placeholder="Enter price (e.g., 10.50)" step="0.01" required>
                            </div>
                        </div>
                        <!-- Quantity -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" class="form-control" id="quantity" value="{{ $drug->quantity }}" placeholder="Enter quantity" required>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>

@endsection
