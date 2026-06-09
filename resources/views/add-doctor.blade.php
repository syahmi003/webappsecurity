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
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">
                        <h2>Fill in doctor details</h2>
                    </div>
                </div>
            </div>
            <div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
                <form action="{{ route('doctor.store') }}" method="post" role="form" enctype="multipart/form-data" style="font-size: 18px;">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="doctor_id" class="form-label">Doctor ID</label>
                              <input type="text" name="doctor_id" class="form-control" id="doctor_id" style="font-size: 18px;" required>
                            </div>
                          </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="doctor_name" class="form-label">Doctor Name</label>
                          <input type="text" name="doctor_name" class="form-control" id="doctor_name" style="font-size: 18px;" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="department" class="form-label">Department</label>
                          <input type="text" name="department" class="form-control" id="department" style="font-size: 18px;" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="email_address" class="form-label">Email Address</label>
                          <input type="email" name="email_address" class="form-control" id="email_address" style="font-size: 18px;" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="schedule" class="form-label">Schedule</label>
                          <input type="text" name="schedule" class="form-control" id="schedule" style="font-size: 18px;" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="contact_no" class="form-label">Contact No</label>
                          <input type="text" name="contact_no" class="form-control" id="contact_no" style="font-size: 18px;" required>
                        </div>
                      </div>
                      <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </form>
              </div>



        </div>
    </div>
    <!-- Team End -->
    </main>

@endsection
