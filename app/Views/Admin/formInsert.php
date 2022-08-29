<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Tambah Data Admin</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/Admin/Insert" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('username') ? 'is-invalid' : ''); ?>" id="username" name="username" value="<?php echo old('username'); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('username'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control <?php echo ($validation->hasError('email') ? 'is-invalid' : ''); ?>" id="email" name="email" value="<?php echo old('email'); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('email'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control <?php echo ($validation->hasError('password') ? 'is-invalid' : ''); ?>" id="password" name="password" value="<?php echo old('password'); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('password'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control <?php echo ($validation->hasError('confirmPwd') ? 'is-invalid' : ''); ?>" id="confirmPwd" name="confirmPwd" value="<?php echo old('confirmPwd'); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('confirmPwd'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Karyawan Penanggung Jawab Akun</label>
            <select class="form-select <?php echo ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik">
                <option selected disabled>Pilih Karyawan</option>
                <?php foreach($user_arr as $user) : ?>
                <option value="<?php echo $user['user_nik']; ?>" <?php echo (old('nik') === $user['user_nik'] ? 'selected' : ''); ?>><?php echo $user['user_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?php echo $validation->getError('nik'); ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>
<?php echo $this->endSection(); ?>