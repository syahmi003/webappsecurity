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
                        <h2>Medical Records</h2>
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
                        <span>Our Medical Records</span>
                        <h2>Dentistry Department</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-right m-3">
                <a class="btn" href="{{ route('medical.create') }}" role="button">Add Record</a>
            </div>

            <div>
                <table class="table" style="font-size: 18px">
                    <thead class="table-gray">
                        <tr>
                            <th scope="col">Record ID</th>
                            <th scope="col">Patient Name</th>
                            <th scope="col">Diagnosis</th>
                            <th scope="col">Treatment</th>
                            <th scope="col">Doctor</th>
                            <th scope="col">Date of Record</th>
                            <th scope="col">Action</th>
                          </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicals as $medical)
                            <tr>
                                <td>{{$medical->record_id}}</td>
                                <td>{{$medical->patient_name}}</td>
                                <td>{{$medical->diagnosis}}</td>
                                <td>{{$medical->treatment}}</td>
                                <td>{{$medical->doctor}}</td>
                                <td>{{$medical->date_of_record}}</td>
                                <td>
                                    <form action="{{ route('medical.destroy',$medical->id) }}" method="POST">
                                        <a class="text-primary" href="{{ route('medical.edit',$medical->id) }}">✏️</a>
                                        @csrf
                                        @method('DELETE')

                                        <a href="#" class="text-danger delete-doctor" data-id="{{ $medical->id }}" title="Delete Record">🗑️</a>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                document.querySelectorAll('.delete-doctor').forEach(function (element) {
                                                    element.addEventListener('click', function (e) {
                                                        e.preventDefault(); // Prevent default link behavior

                                                        const recordId = this.getAttribute('data-id'); // Get doctor ID from data-id attribute
                                                        if (confirm('Are you sure you want to delete this doctor?')) {
                                                            // Create a form dynamically
                                                            const form = document.createElement('form');
                                                            form.action = `/medical/${recordId}`; // Adjust this route as needed
                                                            form.method = 'POST';
                                                            form.style.display = 'none';

                                                            // Add CSRF and method inputs
                                                            const csrfInput = document.createElement('input');
                                                            csrfInput.type = 'hidden';
                                                            csrfInput.name = '_token';
                                                            csrfInput.value = '{{ csrf_token() }}'; // Laravel CSRF token

                                                            const methodInput = document.createElement('input');
                                                            methodInput.type = 'hidden';
                                                            methodInput.name = '_method';
                                                            methodInput.value = 'DELETE';

                                                            form.appendChild(csrfInput);
                                                            form.appendChild(methodInput);
                                                            document.body.appendChild(form); // Append form to the body
                                                            form.submit(); // Submit the form
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
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
