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
                            <h2>Pharmacy</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Team Start -->
    <div class="team-area section-padding30">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">
                        <span>The Medicines</span>
                        <h2>KKM Certified</h2>
                    </div>
                </div>
            </div>

            <!-- Add New Drug Button -->
            <div class="col-md-12 text-right m-3">
                <!-- Add New Record Button -->
                <a href="{{ route('add-drug') }}" class="btn btn-primary">Add New Record</a>
            </div>

            <!-- Drug Table -->
            <div>
                <table class="table" style="font-size: 18px;">
                    <thead class="table-gray">
                        <tr>
                            <th>ID</th>
                            <th>Drug Name</th>
                            <th>Manufacture Date</th>
                            <th>Expiry Date</th>
                            <th>Price</th>
                            <th>Quantity No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drugs as $drug)
                        <tr>
                            <td>{{ $drug->id }}</td>
                            <td>{{ $drug->drug_name }}</td>
                            <td>{{ $drug->manufacture_date }}</td>
                            <td>{{ $drug->expiry_date }}</td>
                            <td>{{ $drug->price }}</td>
                            <td>{{ $drug->quantity }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a class="text-primary" href="{{ route('edit-drug', $drug->id) }}">✏️</a>

                                <!-- Delete Button -->
                                <form action="{{ route('delete-drug', $drug->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-0 border-0 bg-transparent text-danger" style="font-size: 1rem;" onclick="return confirm('Are you sure you want to delete this drug?')">
                                        🗑️
                                    </button>
                                </form>


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection
