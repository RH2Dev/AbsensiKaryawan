<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>

<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Ubah Data Karyawan</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/User/update" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_arr['user_id'] ?>">
        <input type="hidden" class="form-control " id="slug" name="slug" value="<?php echo $user_arr['user_slug']; ?>">
        <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('name') ? 'is-invalid' : ''); ?>" id="name" name="name" value="<?php echo (old('name') ? old('name') : $user_arr['user_name']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('name'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">NIK Karyawan</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik" value="<?php echo (old('name') ? old('nik') : $user_arr['user_nik']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('nik'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select class="form-select <?php echo ($validation->hasError('jenis_kelamin') ? 'is-invalid' : ''); ?>" id="jenis_kelamin" name="jenis_kelamin">
                <option value="Pria">Pria</option>
                <option value="Wanita">Wanita</option>
            </select>
            <div class="invalid-feedback"><?php echo $validation->getError('jenis_kelamin'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan User</label>
            <select class="form-select <?php echo ($validation->hasError('jabatan_id') ? 'is-invalid' : ''); ?>" id="jabatan_id" name="jabatan_id">
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

<script>
    $('#jenis_kelamin').val('<?php echo (old('jenis_kelamin') ? old('jenis_kelamin') : $user_arr['user_jenis_kelamin']); ?>').trigger('change');
    $('#jabatan_id').val('<?php echo (old('jabatan_id') ? old('jabatan_id') : $user_arr['user_jabatan_id']); ?>').trigger('change');
</script>

<?php echo $this->endSection(); ?>