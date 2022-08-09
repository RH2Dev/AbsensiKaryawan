<?= $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>

<?php $session = session()->get(); ?>
<div class="row">
    <?php foreach($user as $user) : ?>
    <div class="col-lg-3 mb-3">
        <div class="card bg-dark text-white shadow">
            <div class="card-body">
                Nama Karyawan
                <div class="text-white-50 small"><?= $user['name']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="card bg-dark text-white shadow">
            <div class="card-body">
                NIK Karyawan
                <div class="text-white-50 small"><?= $user['nik']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="card bg-dark text-white shadow">
            <div class="card-body">
                Jenis Kelamin
                <div class="text-white-50 small"><?= $user['jenis_kelamin']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-3">
        <div class="card bg-dark text-white shadow">
            <div class="card-body">
                Jabatan
                <div class="text-white-50 small"><?= $user['nama_jabatan']; ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-1 font-weight-bold text-primary">Absensi Karyawan</h6>
        <?php if(session()->getFlashData('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($absen)) { ?>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach($absen as $absen) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $absen['tanggal']; ?></td>
                        <td><?= $absen['latitude']; ?> <?= $absen['longitude']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>/Admin/Absensi/<?= $absen['absen_id']; ?>"><button type="button" class="btn btn-warning">Details</button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Tidak Ada Absensi Karyawan
                        </div>
                    <?php } ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col">
                    <?= $pager->links('user', 'pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>