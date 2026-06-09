@extends('master.layout')
@section('content')

<main>
    <!--? Hero Start -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap hero-cap2 text-center">
                        <h2>Patient</h2>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
    <!--? Team Start -->
    <div class="team-area section-padding30">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">
                        <span>Our Patients</span>
                        <h2>Patient List</h2>
                    </div>
                </div>
            </div>
        <!--patient table -->

        <!-- Add Patient Button -->

        <table class="table" style="font-size: 18px;">
            <thead class="table-gray">
                <tr>
                    <th>ID</th>
                    <th>Patient ID</th>
                    <th>Patient Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->patient_id }}</td>
                        <td>{{ $patient->patient_name }}</td>
                        <td>{{ $patient->date_of_birth }}</td>
                        <td>{{ $patient->gender }}</td>
                        <td>{{ $patient->phone_number }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->address }}</td>
                        <td>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" id="delete-form-{{ $patient->id }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <a class="text-primary" href="{{ route('patients.edit', $patient->id) }}">✏️</a>
                                <button type="submit" class="text-danger" onclick="return confirm('Are you sure you want to delete this patient?');">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="col-md-12 text-right m-3">
            <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Add Patient</a>
            </div>
</main>

@endsection
