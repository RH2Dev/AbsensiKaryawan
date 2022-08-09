<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-5">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Tambah Data Absen</h1>
    </div>
    <?php if(session()->getFlashData('pesan')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <?php if($validation->hasError('photo')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $validation->getError('photo'); ?>
        </div>
    <?php endif; ?>
    <?php if($validation->hasError('latitude')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $validation->getError('latitude'); ?>
        </div>
    <?php endif; ?>
    <form class="user" action="<?= base_url(); ?>/Admin/Absensi/insert" method="POST">

        <input class="data-photo" type="hidden" name="photo" value="<?= old('photo'); ?>">
        <input id="latitude" type="hidden" name="latitude" value="<?= old('latitude'); ?>">
        <input id="longitude" type="hidden" name="longitude" value="<?= old('longitude'); ?>">
        <div class="mb-3">
            <label class="form-label">NIK Karyawan</label>
            <input type="text" class="form-control <?= ($validation->hasError('nik') ? 'is-invalid' : ''); ?>" id="nik" name="nik" value="<?= old('nik'); ?>">
            <div class="invalid-feedback"><?= $validation->getError('nik'); ?></div>
        </div>

        <!-- camera section -->
        <div class="display-cover">
            <video autoplay></video>
            <canvas class="d-none"></canvas>

            <div class="video-options">
                <select name="" id="" class="custom-select">
                    <option value="">Select camera</option>
                </select>
            </div>

            <img class="screenshot-image d-none" alt="">

            <div class="controls">
                <button type="button" class="btn btn-danger play" title="Play"><i data-feather="play-circle"></i></button>
                <button type="button" class="btn btn-info pause d-none" title="Pause"><i data-feather="pause"></i></button>
                <button type="button" class="btn btn-outline-success screenshot d-none" title="ScreenShot"><i data-feather="image"></i></button>
            </div>
        </div>
        
        <button  type="button" onclick="getLocation()" class="btn btn-primary">Get Location</button>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
</div>

<script>

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
}
</script>

<script src="https://unpkg.com/feather-icons"></script>
<script src="<?php echo base_url(); ?>/assets/js/camera.js"></script>
<?= $this->endSection(); ?>