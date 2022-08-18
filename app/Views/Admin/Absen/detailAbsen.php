<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>

<?php $session = session()->get(); ?>
<?php foreach($absen_arr as $absen) : ?>
<div class="row">
    <div class="col-lg-6 mb-3">
        <div class="card bg-dark text-white shadow">
            <div class="card-body">
                <img src="<?= base_url(); ?>/img/<?= $absen['absen_photo']; ?>" alt="" width="100%">
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="card bg-dark text-white shadow">
            <div class="card-body">
                <img src="<?= base_url(); ?>/img/<?= $absen['absen_photo_checkout']; ?>" alt="" width="100%">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="row">
        <div class="col-lg-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    Nama Karyawan
                    <div class="text-white-50 small"><?= $absen['user_name']; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    NIK Karyawan
                    <div class="text-white-50 small"><?= $absen['absen_nik']; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    Jabatan
                    <div class="text-white-50 small"><?= $absen['jabatan_nama']; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    Jenis Kelamin
                    <div class="text-white-50 small"><?= $absen['user_jenis_kelamin']; ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    Tanggal Absensi
                    <div class="text-white-50 small"><?= $absen['absen_datetime']; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    Lokasi
                    <div class="text-white-50 small"><?= $absen['absen_latitude']; ?> <?= $absen['absen_longitude']; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    Tanggal Checkout
                    <div class="text-white-50 small"><?= $absen['absen_checkout_datetime']; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    Lokasi
                    <div class="text-white-50 small"><?= $absen['absen_latitude_checkout']; ?> <?= $absen['absen_longitude_checkout']; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $lat = $absen['absen_latitude'];
    $long = $absen['absen_longitude'];
    $latCheckout = $absen['absen_latitude_checkout'];
    $longCheckout = $absen['absen_longitude_checkout'];
?>

<?php endforeach; ?>

<div class="row">
    <div class="col-lg-6">
        <h2>Lokasi Absen</h2>
        <iframe 
        height="400" 
        width="100%"
        frameborder="0" 
        scrolling="no" 
        marginheight="0" 
        marginwidth="0" 
        src="https://maps.google.com/maps?q=<?= $lat; ?>,<?= $long; ?>&hl=en&z=14&amp;output=embed"
        >
        </iframe>
    </div>
    <div class="col-lg-6">
        <h2>Lokasi Checkout</h2>
        <iframe 
        height="400" 
        width="100%"
        frameborder="0" 
        scrolling="no" 
        marginheight="0" 
        marginwidth="0" 
        src="https://maps.google.com/maps?q=<?= $latCheckout; ?>,<?= $longCheckout; ?>&hl=en&z=14&amp;output=embed"
        >
        </iframe>
    </div>
</div>

<?= $this->endSection(); ?>