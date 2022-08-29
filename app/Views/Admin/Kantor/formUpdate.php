<?php echo $this->extend('Admin/layout/template'); ?>

<?php echo $this->section('content'); ?>
<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Tambah Data Kantor</h1>
    </div>
    <form class="user" action="<?php echo base_url(); ?>/Admin/Kantor/update" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" value="<?php echo $kantor_arr['kantor_id']; ?>" id="id" name="id">
        <div class="mb-3">
            <label class="form-label">Nama Kantor</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('name') ? 'is-invalid' : ''); ?>" id="name" name="name" value="<?php echo (old('name') ? old('name') : $kantor_arr['kantor_name']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('name'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">Alamat Kantor</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('alamat') ? 'is-invalid' : ''); ?>" id="alamat" name="alamat" value="<?php echo (old('alamat') ? old('alamat') : $kantor_arr['kantor_alamat']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('alamat'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">Alamat Kantor Latitude</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('latitude') ? 'is-invalid' : ''); ?>" id="latitude" name="latitude" value="<?php echo (old('latitude') ? old('latitude') : $kantor_arr['kantor_latitude']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('latitude'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">Alamat Kantor Longitude</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('longitude') ? 'is-invalid' : ''); ?>" id="longitude" name="longitude" value="<?php echo (old('longitude') ? old('longitude') : $kantor_arr['kantor_longitude']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('longitude'); ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label ">Kantor Radius (digunakan untuk radius absensi)</label>
            <input type="text" class="form-control <?php echo ($validation->hasError('radius') ? 'is-invalid' : ''); ?>" id="radius" name="radius" value="<?php echo (old('radius') ? old('radius') : $kantor_arr['kantor_radius']); ?>">
            <div class="invalid-feedback"><?php echo $validation->getError('radius'); ?></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>
<?php echo $this->endSection(); ?>