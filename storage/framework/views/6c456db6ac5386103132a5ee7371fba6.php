<?php $__env->startSection('content'); ?>
<main>
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
                        <h2>Edit Patient Details</h2>
                    </div>
                </div>
            </div>
    <div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
        <form action="<?php echo e(route('patients.update', $patient->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label for="patient_id">Patient ID</label>
                <input type="text" class="form-control" id="patient_id" name="patient_id" value="<?php echo e($patient->patient_id); ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo e($patient->first_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e($patient->last_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo e($patient->date_of_birth); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="Male" <?php echo e($patient->gender == 'Male' ? 'selected' : ''); ?>>Male</option>
                    <option value="Female" <?php echo e($patient->gender == 'Female' ? 'selected' : ''); ?>>Female</option>
                    <option value="Other" <?php echo e($patient->gender == 'Other' ? 'selected' : ''); ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo e($patient->phone_number); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo e($patient->email); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo e($patient->address); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?php echo e(route('patients.index')); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Project-Web-App-main\resources\views/edit-patient.blade.php ENDPATH**/ ?>