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
                        <h2>Doctors</h2>
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
                        <span>Our Doctors</span>
                        <h2>Our Specialist</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-right m-3">
                <a class="btn" href="{{ route('doctor.create') }}" role="button">Add doctor</a>
            </div>
            <div>
                <table class="table" style="font-size: 18px;">
                    <thead class="table-gray">
                        <tr>
                            <th scope="col">Doctor ID</th>
                            <th scope="col">Doctor Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Schedule</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Action</th>
                          </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $doctor)
                            <tr>
                                <td>{{$doctor->doctor_id}}</td>
                                <td>{{$doctor->doctor_name}}</td>
                                <td>{{$doctor->department}}</td>
                                <td>{{$doctor->email_address}}</td>
                                <td>{{$doctor->schedule}}</td>
                                <td>{{$doctor->contact_no}}</td>
                                <td>
                                    <form action="{{ route('doctor.destroy', $doctor->id) }}" method="POST" id="delete-form-{{ $doctor->id }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a class="text-primary" href="{{ route('doctor.edit', $doctor->id) }}">✏️</a>
                                    <a href="#" class="text-danger delete-doctor" data-id="{{ $doctor->id }}" title="Delete Doctor">🗑️</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <!-- Team End -->
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-doctor').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault(); // Prevent default link behavior

                    const doctorId = this.getAttribute('data-id'); // Get doctor ID from data-id attribute

                    const form = document.getElementById('delete-form-' + doctorId); // Get the form by ID
                    form.submit(); // Submit the form

                });
            });
        });
    </script>

@endsection
