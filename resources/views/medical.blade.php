@extends('master.layout')
@section('content')

<!--? department_area_start  -->
<div class="department_area section-padding2">
    <div class="container">
        <!-- Section Tittle -->
        <div class="row">
            <div class="col-lg-12">
                <div class="section-tittle text-center mb-100">
                    <span>Our Departments</span>
                    <h2>Our Medical Services</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="depart_ment_tab mb-30">
                    <!-- Tabs Buttons -->
                    <ul class="nav" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                                <i class="flaticon-teeth"></i>
                                <h4>Dentistry</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                <i class="flaticon-cardiovascular"></i>
                                <h4>Cardiology</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                <i class="flaticon-ear"></i>
                                <h4>ENT Specialists</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Astrology-tab" data-toggle="tab" href="#Astrology" role="tab" aria-controls="contact" aria-selected="false">
                                <i class="flaticon-bone"></i>
                                <h4>Orthopaedic</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Neuroanatomy-tab" data-toggle="tab" href="#Neuroanatomy" role="tab" aria-controls="contact" aria-selected="false">
                                <i class="flaticon-lung"></i>
                                <h4>Pulmonology</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Blood-tab" data-toggle="tab" href="#Blood" role="tab" aria-controls="contact" aria-selected="false">
                                <i class="flaticon-cell"></i>
                                <h4>Blood Screening</h4>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="dept_main_info white-bg">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <!-- single_content  -->
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-7">
                            <!-- Dentistry -->
                            <div class="dept_info">
                                <h3>Dentistry Department</h3 >
                                <p>Our Dentistry Department is dedicated to providing comprehensive oral health care for patients of all ages. We strive to deliver the highest standards of dental care, helping you achieve a healthy and confident smile. </p>
                                <a href="{{ route('medical.view_more') }}" class="dep-btn">View Records<i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="dept_thumb">
                                <img src="assets/img/gallery/dentistry1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- single_content  -->
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <!-- single_content  -->
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-7">
                            <!-- Cardiology -->
                            <div class="dept_info">
                                <h3>Cardiology Department</h3 >
                                <p>Our Cardiology Department is committed to providing exceptional heart care. We specialize in diagnosing and treating cardiovascular conditions, working with you to ensure a healthy heart and improve your overall well-being. Trust us to support your journey to a healthier heart. </p>
                                <a href="#" class="dep-btn">View Records<i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="dept_thumb">
                                <img src="assets/img/gallery/cardiology1.jpg" alt="" width="500" height="300">
                            </div>
                        </div>
                    </div>
                    <!-- single_content  -->
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <!-- single_content  -->
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-7">
                            <!-- ENT -->
                            <div class="dept_info">
                                <h3>ENT Specialist Department</h3 >
                                <p>Our ENT Specialists are here to diagnose and treat conditions affecting the ear, nose, and throat. Whether it's hearing loss, sinus issues, or throat problems, we provide advanced care to ensure you breathe, hear, and speak with ease, helping you live a more comfortable life.</p>
                                <a href="#" class="dep-btn">View Records<i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="dept_thumb">
                                <img src="assets/img/gallery/ent1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- single_content  -->
                </div>
                <div class="tab-pane fade" id="Astrology" role="tabpanel" aria-labelledby="Astrology-tab">
                    <!-- single_content  -->
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-7">
                            <!-- Orthopaedic -->
                            <div class="dept_info">
                                <h3>Orthopaedic Department</h3 >
                                <p>Our Orthopaedic Department specializes in the diagnosis, treatment, and rehabilitation of musculoskeletal conditions. Whether you're dealing with fractures, joint pain, or sports injuries, our team of experts is dedicated to improving your mobility and helping you live a pain-free, active life.</p>
                                <a href="#" class="dep-btn">View Records<i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="dept_thumb">
                                <img src="assets/img/gallery/orto1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- single_content  -->
                </div>
                <div class="tab-pane fade" id="Neuroanatomy" role="tabpanel" aria-labelledby="Neuroanatomy-tab">
                    <!-- single_content  -->
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-7">
                            <!-- Pulmonology -->
                            <div class="dept_info">
                                <h3>Pulmonology Department</h3 >
                                <p>Our Pulmonology Department is dedicated to diagnosing and treating respiratory conditions. From asthma and COPD to lung infections and sleep apnea, our specialists provide comprehensive care to help you breathe easier and improve your lung health for a better quality of life.</p>
                                <a href="#" class="dep-btn">View Records<i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="dept_thumb">
                                <img src="assets/img/gallery/pulmo1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- single_content  -->
                </div>
                <div class="tab-pane fade" id="Blood" role="tabpanel" aria-labelledby="Blood-tab">
                    <!-- single_content  -->
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-7">
                            <!-- Blood Screening -->
                            <div class="dept_info">
                                <h3>Blood Screening Department</h3 >
                                <p>Our Blood Screening services provide comprehensive testing to monitor your health. With advanced diagnostic technology, we help detect early signs of diseases and conditions, offering you the information you need to maintain your health and wellness.</p>
                                <a href="#" class="dep-btn">View Records<i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="dept_thumb">
                                <img src="assets/img/gallery/blood1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- single_content  -->
                </div>
                </div>
        </div>

    </div>
</div>
<!-- depertment area end  -->
@endsection
