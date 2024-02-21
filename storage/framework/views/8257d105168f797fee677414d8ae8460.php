<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
    <a href="<?php echo e(route('admin.sale.show', $notification->id)); ?>" class="btn btn-primary">Посмотреть</a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\Users\maksi\Desktop\Мои_сайты\kitprotv\resources\views/layouts/notifications.blade.php ENDPATH**/ ?>