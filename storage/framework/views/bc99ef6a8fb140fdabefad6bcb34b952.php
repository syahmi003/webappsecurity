<?php $__env->startSection('content'); ?>

<main>
    <!--? Hero Start -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <!-- Section Title -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">

                        <h2>Appointment</h2>
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
                        <span>Appointment</span>
                        <h2>Book Appointment</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-12 text-right m-3">
                <a class="btn" href="<?php echo e(route('appointments.create')); ?>" role="button">Add appointment</a>
            </div>

                <table class="table" style="font-size: 18px;">
                    <thead class="table-gray">

            <tr>
                <th scope ="col">Appointment ID</th>
                <th scope ="col">Patient ID</th>
                <th scope ="col">Doctor ID</th>
                <th scope ="col">Appointment Date</th>
                <th scope ="col">Appointment Time</th>
                <th scope ="col">Action</th>
            </tr>

        </thead>
        <tbody>
            <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($appointment->appointment_id); ?></td>
                    <td><?php echo e($appointment->patient_id); ?></td>
                    <td><?php echo e($appointment->doctor_id); ?></td>
                    <td><?php echo e($appointment->appointment_date); ?></td>
                    <td><?php echo e($appointment->appointment_time); ?></td>

                    <td>
                        <form action="<?php echo e(route('appointments.destroy', $appointment->id)); ?>" method="POST" id="delete-form-<?php echo e($appointment->id); ?>" style="display: none;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                        </form>
                        <a class="text-primary" href="<?php echo e(route('appointments.edit', $appointment->id)); ?>">✏️</a>
                        <a href="#" class="text-danger delete-appointment" data-id="<?php echo e($appointment->id); ?>" title="Delete Appointment">🗑️</a>
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
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-appointment').forEach(function (element) {
            element.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default link behavior

                const appointmentId = this.getAttribute('data-id');

                if (confirm('Are you sure you want to delete this appointment?')) {
                const form = document.getElementById('delete-form-' + appointmentId); // Get the form by ID
                form.submit(); // Submit the form

            });
        });
    });
</script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('master.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Project-Web-App-main\resources\views/add-appointment.blade.php ENDPATH**/ ?>