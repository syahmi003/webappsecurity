<?php $__env->startSection('content'); ?>

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
                <a class="btn" href="<?php echo e(route('doctor.create')); ?>" role="button">Add doctor</a>
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
                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($doctor->doctor_id); ?></td>
                                <td><?php echo e($doctor->doctor_name); ?></td>
                                <td><?php echo e($doctor->department); ?></td>
                                <td><?php echo e($doctor->email_address); ?></td>
                                <td><?php echo e($doctor->schedule); ?></td>
                                <td><?php echo e($doctor->contact_no); ?></td>
                                <td>
                                    <form action="<?php echo e(route('doctor.destroy', $doctor->id)); ?>" method="POST" id="delete-form-<?php echo e($doctor->id); ?>" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                    <a class="text-primary" href="<?php echo e(route('doctor.edit', $doctor->id)); ?>">✏️</a>
                                    <a href="#" class="text-danger delete-doctor" data-id="<?php echo e($doctor->id); ?>" title="Delete Doctor">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Project-Web-App-main\resources\views/doctor.blade.php ENDPATH**/ ?>