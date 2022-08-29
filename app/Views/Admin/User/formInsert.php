<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Tambah Data Karyawan</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/User/insert" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('name') ? 'is-invalid' : ''); ?>" id="name" name="name" value="<?php echo old('name'); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('name'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">NIK Karyawan</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik" value="<?php echo old('nik'); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('nik'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select class="form-select <?php echo ($validation->hasError('jenis_kelamin') ? 'is-invalid' : ''); ?>" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo old('jenis_kelamin'); ?>">
                <option selected disabled>Pilih Jenis Kelamin User</option>
                <option value="Pria" <?php echo (old('jenis_kelamin') == 'Pria' ? 'selected' : ''); ?>>Pria</option>
                <option value="Wanita" <?php echo (old('jenis_kelamin') == 'Wanita' ? 'selected' : ''); ?>>Wanita</option>
            </select>
            <div class="invalid-feedback"><?php echo $validation->getError('jenis_kelamin'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan User</label>
            <select class="form-select <?php echo ($validation->hasError('jabatan_id') ? 'is-invalid' : ''); ?>" id="jabatan_id" name="jabatan_id" value="<?php echo old('nama_jabatan'); ?>">
                <option selected disabled>Pilih Jabatan User</option>
                <?php foreach($jabatan_arr as $jabatan) : ?>
                <option value="<?php echo $jabatan['jabatan_id'] ?>" <?php echo (old('jabatan_id') == $jabatan['jabatan_id'] ? 'selected' : ''); ?>><?php echo $jabatan['jabatan_nama'] ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?php echo $validation->getError('jabatan_id'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Kantor User</label>
            <select class="form-select <?php echo ($validation->hasError('user_kantor_id') ? 'is-invalid' : ''); ?>" id="user_kantor_id" name="user_kantor_id">
                <option selected disabled>Pilih Kantor User</option>

                <?php foreach ($kantor_arr as $kantor) : ?>
                <option value="<?php echo $kantor['kantor_id'] ?>" <?php echo (old('user_kantor_id') == $kantor['kantor_id'] ? 'selected' : ''); ?>><?php echo $kantor['kantor_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?php echo $validation->getError('user_kantor_id'); ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>
<?php echo $this->endSection(); ?>