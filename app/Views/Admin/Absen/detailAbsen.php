<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>

<?php $session = session()->get(); ?>
<div class="row">
    <?php foreach($absen as $absen) : ?>
        
    <div class="col-lg-6 mb-3">
        <div class="card bg-dark text-white shadow">
            <div class="card-body">
                <img src="<?= base_url(); ?>/img/<?= $absen['photo']; ?>" alt="" width="100%">
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Nama Karyawan
                        <div class="text-white-50 small"><?= $absen['name']; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        NIK Karyawan
                        <div class="text-white-50 small"><?= $absen['nik']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Tanggal Absensi
                        <div class="text-white-50 small"><?= $absen['tanggal']; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Jabatan
                        <div class="text-white-50 small"><?= $absen['nama_jabatan']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Jenis Kelamin
                        <div class="text-white-50 small"><?= $absen['jenis_kelamin']; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Lokasi
                        <div class="text-white-50 small"><?= $absen['latitude']; ?> <?= $absen['longitude']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $lat = $absen['latitude'];
    $long = $absen['longitude'];
?>

<?php endforeach; ?>

<div class="row">
    <iframe 
    height="400" 
    frameborder="0" 
    scrolling="no" 
    marginheight="0" 
    marginwidth="0" 
    src="https://maps.google.com/maps?q=<?= $lat; ?>,<?= $long; ?>&hl=es&z=14&amp;output=embed"
    >
    </iframe>
</div>

<?= $this->endSection(); ?>