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
                        <h2>Edit Medical Records</h2>
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
            <div>
                <h2>Edit medical record details</h2>
            </div>
            <div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
                <form action="{{ route('medical.update',$medical->id) }}" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                              <input type="text" name="record_id" class="form-control" id="record_id" value="{{ $medical->record_id }}" required>
                            </div>
                          </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <input type="text" name="patient_name" class="form-control" id="patient_name" value="{{ $medical->patient_name }}" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <input type="text" name="diagnosis" class="form-control" id="diagnosis" value="{{ $medical->diagnosis }}" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <input type="text" name="treatment" class="form-control" id="treatment" value="{{ $medical->treatment }}" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <input type="text" name="doctor" class="form-control" id="doctor" value="{{ $medical->doctor }}" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <input type="date" name="date_of_record" class="form-control" id="date_of_record" value="{{ $medical->date_of_record }}" required>
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
