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
        <div class="team-area section-padding30">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-tittle text-center mb-100">
                            <h2>Register New Patient</h2>
                        </div>
                    </div>
                </div>
<!--register new patient-->
<div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="patient_id">Patient ID</label>
            <input type="text" name="patient_id" id="patient_id" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Patient</button>
    </form>
</div>

</main>

@endsection
