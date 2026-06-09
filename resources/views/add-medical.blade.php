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
                        <span>New Record Form</span>
                        <h2>Dentistry Department</h2>
                    </div>
                </div>
            </div>
            <div>
                <h2>Fill in dentistry department details</h2>
            </div>
            <div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
                <form action="{{ route('medical.store') }}" method="post" role="form" enctype="multipart/form-data" style="font-size: 18px;">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <h4>Record ID</h4>
                              <input type="text" name="record_id" class="form-control" id="record_id" placeholder="DSXX" required>
                            </div>
                          </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <h4>Patient Name</h4>
                          <input type="text" name="patient_name" class="form-control" id="patient_name" placeholder="Patient Name" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <h4>Diagnosis</h4>
                          <input type="text" name="diagnosis" class="form-control" id="diagnosis" placeholder="Diagnosis" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <h4>Treatment</h4>
                          <input type="text" name="treatment" class="form-control" id="treatment" placeholder="Treatment" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <h4>Doctor</h4>
                          <input type="text" name="doctor" class="form-control" id="doctor" placeholder="Doctor" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <h4>Date of Records</h4>
                            <input type="date" name="date_of_record" class="form-control" id="date_of_records" placeholder="DD-MM-YYYY" required>
                        </div>
                      </div>
                      <div class="col-md-12 text-center">
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
