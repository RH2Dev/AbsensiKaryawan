<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Tambah Data Karyawan</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/User/insertData" method="POST">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control <?= ($validation->hasError('name') ? 'is-invalid' : ''); ?>" id="name" name="name" value="<?= old('name'); ?>">
            <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">NIK Karyawan</label>
            <input type="text" class="form-control <?= ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik" value="<?= old('nik'); ?>">
            <div class="invalid-feedback"><?= $validation->getError('nik'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select class="form-select <?= ($validation->hasError('jenis_kelamin') ? 'is-invalid' : ''); ?>" id="jenis_kelamin" name="jenis_kelamin" value="<?= old('jenis_kelamin'); ?>">
                <option selected disabled>Pilih Jenis Kelamin User</option>
                <option value="Pria" <?= (old('jenis_kelamin') == 'Pria' ? 'selected' : ''); ?>>Pria</option>
                <option value="Wanita" <?= (old('jenis_kelamin') == 'Wanita' ? 'selected' : ''); ?>>Wanita</option>
            </select>
            <div class="invalid-feedback"><?= $validation->getError('jenis_kelamin'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan User</label>
            <select class="form-select <?= ($validation->hasError('jabatan_id') ? 'is-invalid' : ''); ?>" id="jabatan_id" name="jabatan_id" value="<?= old('nama_jabatan'); ?>">
                <option selected disabled>Pilih Jabatan User</option>
                <option value="1" <?= (old('jabatan_id') == 1 ? 'selected' : ''); ?>>CEO</option>
                <option value="2" <?= (old('jabatan_id') == 2 ? 'selected' : ''); ?>>Manager</option>
                <option value="3" <?= (old('jabatan_id') == 3 ? 'selected' : ''); ?>>Human Resource</option>
                <option value="4" <?= (old('jabatan_id') == 4 ? 'selected' : ''); ?>>Karyawan</option>
            </select>
            <div class="invalid-feedback"><?= $validation->getError('jabatan_id'); ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>
<?= $this->endSection(); ?>