<?php $__env->startSection('content'); ?>

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
                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($patient->id); ?></td>
                        <td><?php echo e($patient->patient_id); ?></td>
                        <td><?php echo e($patient->patient_name); ?></td>
                        <td><?php echo e($patient->date_of_birth); ?></td>
                        <td><?php echo e($patient->gender); ?></td>
                        <td><?php echo e($patient->phone_number); ?></td>
                        <td><?php echo e($patient->email); ?></td>
                        <td><?php echo e($patient->address); ?></td>
                        <td>
                            <form action="<?php echo e(route('patients.destroy', $patient->id)); ?>" method="POST" id="delete-form-<?php echo e($patient->id); ?>" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <a class="text-primary" href="<?php echo e(route('patients.edit', $patient->id)); ?>">✏️</a>
                                <button type="submit" class="text-danger" onclick="return confirm('Are you sure you want to delete this patient?');">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="col-md-12 text-right m-3">
            <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary mb-3">Add Patient</a>
            </div>
</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Project-Web-App-main\resources\views/patient.blade.php ENDPATH**/ ?>