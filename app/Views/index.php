<?php echo $this->extend('Layout/template'); ?>

<?php echo $this->section('content'); ?>
    <div class="display-cover">
        <video autoplay></video>
        <canvas class="d-none"></canvas>
        <form id="absen" action="<?php echo base_url(); ?>/insert" method="POST">
            <input id="latitude" type="hidden" name="latitude" value="<?php echo old('latitude'); ?>">
            <input id="longitude" type="hidden" name="longitude" value="<?php echo old('longitude'); ?>">
            <input class="data-photo" type="hidden" name="photo" value="<?php echo old('photo'); ?>">

            <div class="form-input">
                <h3 class="title">ABSENSI KARYAWAN</h3>
                <p class="error-message"><?php echo (session()->getFlashData('pesan') ? session()->getFlashdata('pesan'): ''); ?></p>
                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo old('nik'); ?>" placeholder="Masukkan NIK anda">
                <button class="btn btn-primary mb-2" type="button" onclick="absen()"> Submit </button>

                <a href="<?php echo base_url() ?>/Izin" style="font-weight: 800">Formulir Izin Karyawan</a>
            </div>

            <img class="screenshot-image d-none" alt="" />

            <div class="controls">
                <button type="button" class="btn btn-outline-success screenshot d-none" title="ScreenShot" id="screenshot">
                    <i data-feather="image"></i>
                </button>
            </div>
        </form>
    </div>
<!-- Core plugin JavaScript-->
<script src="https://unpkg.com/feather-icons"></script>
<script src="<?php echo base_url(); ?>/assets/js/camera2.js"></script>
<script>
function absen() {
$('#screenshot').click();
}
</script>

<?php echo $this->endSection(); ?>