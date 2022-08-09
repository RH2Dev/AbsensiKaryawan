<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Tambah Data Admin</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/Admin/Insert" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control <?= ($validation->hasError('username') ? 'is-invalid' : ''); ?>" id="username" name="username" value="<?= old('username'); ?>">
            <div class="invalid-feedback"><?= $validation->getError('username'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : ''); ?>" id="email" name="email" value="<?= old('email'); ?>">
            <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control <?= ($validation->hasError('password') ? 'is-invalid' : ''); ?>" id="password" name="password" value="<?= old('password'); ?>">
            <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control <?= ($validation->hasError('confirmPwd') ? 'is-invalid' : ''); ?>" id="confirmPwd" name="confirmPwd" value="<?= old('confirmPwd'); ?>">
            <div class="invalid-feedback"><?= $validation->getError('confirmPwd'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Karyawan Penanggung Jawab Akun</label>
            <select class="form-select <?= ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik">
                <option selected disabled>Pilih Karyawan</option>
                <?php foreach($user as $user) : ?>
                <option value="<?= $user['nik']; ?>" <?= (old('nik') === $user['nik'] ? 'selected' : ''); ?>><?= $user['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?= $validation->getError('nik'); ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>
<?= $this->endSection(); ?>