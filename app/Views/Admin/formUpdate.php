<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Update Data Admin</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/Admin/Update/<?php echo $admin_arr['auth_id']; ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" id="id" value="<?php echo $admin_arr['auth_id']; ?>">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('username') ? 'is-invalid' : ''); ?>" id="username" name="username" value="<?php echo (old('username') ? old('username') : $admin_arr['auth_username']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('username'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control <?php echo ($validation->hasError('email') ? 'is-invalid' : ''); ?>" id="email" name="email" value="<?php echo (old('email') ? old('email') : $admin_arr['auth_email']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('email'); ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>
<?php echo $this->endSection(); ?>