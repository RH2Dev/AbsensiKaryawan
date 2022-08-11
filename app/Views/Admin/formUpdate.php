<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Update Data Admin</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/Admin/Update/<?= $admin['admin_id']; ?>" method="POST">
        <?= csrf_field(); ?>
        <input type="hidden" name="id" id="id" value="<?= $admin['admin_id']; ?>">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control <?= ($validation->hasError('username') ? 'is-invalid' : ''); ?>" id="username" name="username" value="<?= (old('username') ? old('username') : $admin['username']); ?>">
            <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : ''); ?>" id="email" name="email" value="<?= (old('email') ? old('email') : $admin['email']); ?>">
            <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>
<?= $this->endSection(); ?>