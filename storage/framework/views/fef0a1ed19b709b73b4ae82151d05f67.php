<?php $__env->startSection('content'); ?>

<main>
    <!-- Hero Start -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap hero-cap2 text-center">
                            <h2>Pharmacy</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Team Start -->
    <div class="team-area section-padding30">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-tittle text-center mb-100">
                        <span>The Medicines</span>
                        <h2>KKM Certified</h2>
                    </div>
                </div>
            </div>

            <!-- Add New Drug Button -->
            <div class="col-md-12 text-right m-3">
                <!-- Add New Record Button -->
                <a href="<?php echo e(route('add-drug')); ?>" class="btn btn-primary">Add New Record</a>
            </div>

            <!-- Drug Table -->
            <div>
                <table class="table" style="font-size: 18px;">
                    <thead class="table-gray">
                        <tr>
                            <th>ID</th>
                            <th>Drug Name</th>
                            <th>Manufacture Date</th>
                            <th>Expiry Date</th>
                            <th>Price</th>
                            <th>Quantity No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $drugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $drug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($drug->id); ?></td>
                            <td><?php echo e($drug->drug_name); ?></td>
                            <td><?php echo e($drug->manufacture_date); ?></td>
                            <td><?php echo e($drug->expiry_date); ?></td>
                            <td><?php echo e($drug->price); ?></td>
                            <td><?php echo e($drug->quantity); ?></td>
                            <td>
                                <!-- Edit Button -->
                                <a class="text-primary" href="<?php echo e(route('edit-drug', $drug->id)); ?>">✏️</a>

                                <!-- Delete Button -->
                                <form action="<?php echo e(route('delete-drug', $drug->id)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-0 border-0 bg-transparent text-danger" style="font-size: 1rem;" onclick="return confirm('Are you sure you want to delete this drug?')">
                                        🗑️
                                    </button>
                                </form>


                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Project-Web-App-main\resources\views/pharmacy.blade.php ENDPATH**/ ?>