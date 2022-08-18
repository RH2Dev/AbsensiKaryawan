<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Ubah Data Karyawan</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/User/update/<?= $user_arr['user_id']; ?>" method="POST">
        <?= csrf_field(); ?>
        <input type="hidden" class="form-control " id="slug" name="slug" value="<?= $user_arr['user_slug']; ?>">
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control <?= ($validation->hasError('name') ? 'is-invalid' : ''); ?>" id="name" name="name" value="<?= (old('name') ? old('name') : $user_arr['user_name']); ?>">
            <div class="invalid-feedback"><?= $validation->getError('name'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">NIK Karyawan</label>
            <input type="text" class="form-control <?= ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik" value="<?= (old('name') ? old('nik') : $user_arr['user_nik']); ?>">
            <div class="invalid-feedback"><?= $validation->getError('nik'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select class="form-select <?= ($validation->hasError('jenis_kelamin') ? 'is-invalid' : ''); ?>" id="jenis_kelamin" name="jenis_kelamin">
                <option value="Pria">Pria</option>
                <option value="Wanita">Wanita</option>
            </select>
            <div class="invalid-feedback"><?= $validation->getError('jenis_kelamin'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan User</label>
            <select class="form-select <?= ($validation->hasError('jabatan_id') ? 'is-invalid' : ''); ?>" id="jabatan_id" name="jabatan_id">
                <option value="1">CEO</option>
                <option value="2">Manager</option>
                <option value="3">Human Resource</option>
                <option value="4">Karyawan</option>
            </select>
            <div class="invalid-feedback"><?= $validation->getError('jabatan_id'); ?></div>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>

<script>
    $('#jenis_kelamin').val('<?= (old('jenis_kelamin') ? old('jenis_kelamin') : $user_arr['user_jenis_kelamin']); ?>').trigger('change');
    $('#jabatan_id').val('<?= (old('jabatan_id') ? old('jabatan_id') : $user_arr['user_jabatan_id']); ?>').trigger('change');
</script>

<?= $this->endSection(); ?>